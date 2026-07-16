<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Roombook;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RoombookController extends Controller
{
    /** Bookings table + add form */
    public function index()
    {
        return view('admin.roombook', [
            'bookings' => Roombook::all(),
            'countries' => HomeController::countries(),
        ]);
    }

    /** Admin-side "Add" reservation */
    public function store(Request $request)
    {
        $name = $request->input('Name');
        $email = $request->input('Email');
        $country = $request->input('Country');

        if ($name == '' || $email == '' || $country == '') {
            return back()->with('error', 'Fill the proper details');
        }

        $cin = $request->input('cin');
        $cout = $request->input('cout');

        Roombook::create([
            'Name' => $name,
            'Email' => $email,
            'Country' => $country,
            'Phone' => $request->input('Phone'),
            'RoomType' => $request->input('RoomType'),
            'Bed' => $request->input('Bed'),
            'NoofRoom' => 'Pending', 
            'Meal' => $request->input('Meal'),
            'cin' => $cin,
            'cout' => $cout,
            'stat' => 'NotConfirm',
            'nodays' => HomeController::dayDiff($cin, $cout),
        ]);

        return back()->with('success', 'Reservation successful');
    }

    /** ✅ UPDATED: Find valid, vacant rooms matching this exact reservation spec */
/** ✅ FIXED: Scans full inventory to build a real-time reactive availability map */
    public function edit($id)
    {
        $booking = Roombook::where('id', $id)->firstOrFail();
        $countries = HomeController::countries();

        // 1. Fetch all rooms registered in the system
        $allRooms = Room::all();
        
        // 2. Build a mapped dictionary grouped by "RoomType_Bedding"
        $roomsMap = [];
        
        foreach ($allRooms as $room) {
            // Check if this room is already occupied by a confirmed guest during these dates
            $isOccupied = Roombook::where('id', '!=', $id)
                ->where('NoofRoom', $room->room_no)
                ->where('stat', 'Confirm')
                ->where(function($query) use ($booking) {
                    $query->whereBetween('cin', [$booking->cin, $booking->cout])
                          ->orWhereBetween('cout', [$booking->cin, $booking->cout])
                          ->orWhere(function($sub) use ($booking) {
                              $sub->where('cin', '<=', $booking->cin)->where('cout', '>=', $booking->cout);
                          });
                })->exists();

            // If the room is vacant, sort it into our available options map
            if (!$isOccupied) {
                $key = $room->type . '_' . $room->bedding;
                if (!isset($roomsMap[$key])) {
                    $roomsMap[$key] = [];
                }
                $roomsMap[$key][] = $room->room_no;
            }
        }

        return view('admin.roombookedit', compact('booking', 'countries', 'roomsMap'));
    }

    /** ✅ UPDATED: Save edits with strict server-side fallback validation checks */
    public function update(Request $request, $id)
    {
        $booking = Roombook::where('id', $id)->firstOrFail();

        $cin = $request->input('cin');
        $cout = $request->input('cout');
        $nodays = HomeController::dayDiff($cin, $cout);

        $roomType = $request->input('RoomType');
        $bed = $request->input('Bed');
        $meal = $request->input('Meal');
        $roomNo = $request->input('NoofRoom');

        if ($roomNo !== 'Pending') {
            // Find the room in the inventory database
            $room = Room::where('room_no', $roomNo)->first();
            
            // Validation Check A: Verify existence
            if (!$room) {
                return back()->with('error', "Room #{$roomNo} does not exist in your inventory!");
            }

            // Validation Check B: Verify that Room Type and Bed layout match the inventory parameters
            if ($room->type !== $roomType || $room->bedding !== $bed) {
                return back()->with('error', "Invalid configuration! Room #{$roomNo} is registered as a {$room->type} with a {$room->bedding} Bed layout.");
            }

            // Validation Check C: Verify calendar overlap schedule availability
            $isOccupied = Roombook::where('id', '!=', $id)
                ->where('NoofRoom', $roomNo)
                ->where('stat', 'Confirm')
                ->where(function($query) use ($cin, $cout) {
                    $query->whereBetween('cin', [$cin, $cout])
                          ->orWhereBetween('cout', [$cin, $cout])
                          ->orWhere(function($sub) use ($cin, $cout) {
                              $sub->where('cin', '<=', $cin)->where('cout', '>=', $cout);
                          });
                })->exists();

            if ($isOccupied) {
                return back()->with('error', "Conflict! Room #{$roomNo} is already occupied by a confirmed guest during these dates.");
            }
        }

        $booking->update([
            'Name' => $request->input('Name'),
            'Email' => $request->input('Email'),
            'Country' => $request->input('Country'),
            'Phone' => $request->input('Phone'),
            'RoomType' => $roomType,
            'Bed' => $bed,
            'NoofRoom' => $roomNo,
            'Meal' => $meal,
            'cin' => $cin,
            'cout' => $cout,
            'nodays' => $nodays,
        ]);

        [$roomtotal, $bedtotal, $mealtotal, $finaltotal] =
            Payment::calculate($roomType, $bed, $meal, $nodays);

        Payment::where('id', $id)->update([
            'Name' => $request->input('Name'),
            'Email' => $request->input('Email'),
            'RoomType' => $roomType,
            'Bed' => $bed,
            'NoofRoom' => $roomNo,
            'Meal' => $meal,
            'cin' => $cin,
            'cout' => $cout,
            'noofdays' => $nodays,
            'roomtotal' => $roomtotal,
            'bedtotal' => $bedtotal,
            'mealtotal' => $mealtotal,
            'finaltotal' => $finaltotal,
        ]);

        return redirect()->route('admin.roombook')->with('success', 'Reservation updated and verified!');
    }

    public function confirm($id)
    {
        $booking = Roombook::where('id', $id)->firstOrFail();

        if ($booking->stat === 'NotConfirm') {
            if ($booking->NoofRoom === 'Pending') {
                return back()->with('error', 'Please select and assign a valid Room Number using the Edit panel before confirming this booking!');
            }

            $booking->update(['stat' => 'Confirm']);

            [$roomtotal, $bedtotal, $mealtotal, $finaltotal] = Payment::calculate(
                $booking->RoomType,
                $booking->Bed,
                $booking->Meal,
                (int) $booking->nodays
            );

            Payment::create([
                'id' => $booking->id,
                'Name' => $booking->Name,
                'Email' => $booking->Email,
                'RoomType' => $booking->RoomType,
                'Bed' => $booking->Bed,
                'NoofRoom' => $booking->NoofRoom,
                'cin' => $booking->cin,
                'cout' => $booking->cout,
                'noofdays' => $booking->nodays,
                'roomtotal' => $roomtotal,
                'bedtotal' => $bedtotal,
                'meal' => $booking->Meal,
                'mealtotal' => $mealtotal,
                'finaltotal' => $finaltotal,
            ]);
        }

        return redirect()->route('admin.roombook')->with('success', 'Booking confirmed successfully!');
    }

    public function destroy($id)
    {
        Roombook::where('id', $id)->delete();
        return redirect()->route('admin.roombook');
    }

    public function export(): StreamedResponse
    {
        $filename = 'bluebird_roombook_data_'.date('Ymd').'.xls';
        $bookings = Roombook::all();

        return response()->streamDownload(function () use ($bookings) {
            $out = fopen('php://output', 'w');
            $shownHeader = false;
            foreach ($bookings as $record) {
                $row = $record->getAttributes();
                if (! $shownHeader) {
                    fwrite($out, implode("\t", array_keys($row))."\n");
                    $shownHeader = true;
                }
                fwrite($out, implode("\t", array_values($row))."\n");
            }
            fclose($out);
        }, $filename, ['Content-Type' => 'application/vnd.ms-excel']);
    }
}