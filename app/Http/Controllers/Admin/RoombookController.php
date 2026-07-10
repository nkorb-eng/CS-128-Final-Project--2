<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;
use App\Models\Payment;
use App\Models\Roombook;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RoombookController extends Controller
{
    /** Bookings table + add form (was roombook.php). */
    public function index()
    {
        return view('admin.roombook', [
            'bookings' => Roombook::all(),
            'countries' => HomeController::countries(),
        ]);
    }

    /** Admin-side "Add" reservation. */
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
            'NoofRoom' => $request->input('NoofRoom'),
            'Meal' => $request->input('Meal'),
            'cin' => $cin,
            'cout' => $cout,
            'stat' => 'NotConfirm',
            'nodays' => HomeController::dayDiff($cin, $cout),
        ]);

        return back()->with('success', 'Reservation successful');
    }

    /** Edit reservation form (was roombookedit.php GET part). */
    public function edit($id)
    {
        return view('admin.roombookedit', [
            'booking' => Roombook::where('id', $id)->firstOrFail(),
            'countries' => HomeController::countries(),
        ]);
    }

    /** Save edits, and keep the matching payment row in sync. */
    public function update(Request $request, $id)
    {
        $booking = Roombook::where('id', $id)->firstOrFail();

        $cin = $request->input('cin');
        $cout = $request->input('cout');
        $nodays = HomeController::dayDiff($cin, $cout);

        $roomType = $request->input('RoomType');
        $bed = $request->input('Bed');
        $meal = $request->input('Meal');
        $noofRoom = $request->input('NoofRoom');

        $booking->update([
            'Name' => $request->input('Name'),
            'Email' => $request->input('Email'),
            'Country' => $request->input('Country'),
            'Phone' => $request->input('Phone'),
            'RoomType' => $roomType,
            'Bed' => $bed,
            'NoofRoom' => $noofRoom,
            'Meal' => $meal,
            'cin' => $cin,
            'cout' => $cout,
            'nodays' => $nodays,
        ]);

        // Recompute and update the payment row if one exists for this booking.
        [$roomtotal, $bedtotal, $mealtotal, $finaltotal] =
            Payment::calculate($roomType, $bed, $meal, $nodays, (int) $noofRoom);

        Payment::where('id', $id)->update([
            'Name' => $request->input('Name'),
            'Email' => $request->input('Email'),
            'RoomType' => $roomType,
            'Bed' => $bed,
            'NoofRoom' => $noofRoom,
            'Meal' => $meal,
            'cin' => $cin,
            'cout' => $cout,
            'noofdays' => $nodays,
            'roomtotal' => $roomtotal,
            'bedtotal' => $bedtotal,
            'mealtotal' => $mealtotal,
            'finaltotal' => $finaltotal,
        ]);

        return redirect()->route('admin.roombook');
    }

    /** Confirm a booking and create its payment (was roomconfirm.php). */
    public function confirm($id)
    {
        $booking = Roombook::where('id', $id)->firstOrFail();

        if ($booking->stat === 'NotConfirm') {
            $booking->update(['stat' => 'Confirm']);

            [$roomtotal, $bedtotal, $mealtotal, $finaltotal] = Payment::calculate(
                $booking->RoomType,
                $booking->Bed,
                $booking->Meal,
                (int) $booking->nodays,
                (int) $booking->NoofRoom
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

        return redirect()->route('admin.roombook');
    }

    public function destroy($id)
    {
        Roombook::where('id', $id)->delete();

        return redirect()->route('admin.roombook');
    }

    /** Export bookings as a tab-separated .xls download (was exportdata.php). */
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
