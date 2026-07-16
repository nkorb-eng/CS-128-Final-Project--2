<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        // Get the requested sort order (defaults to room_no)
        $sort = $request->query('sort', 'room_no');

        // Fetch the rooms from the database in the requested order
        if ($sort === 'room_no') {
            $rooms = Room::orderByRaw('CAST(room_no AS UNSIGNED) ASC')->get();
        } elseif (in_array($sort, ['type', 'bedding', 'price'])) {
            $rooms = Room::orderBy($sort, 'asc')->get();
        } else {
            $rooms = Room::all();
        }

        // Build price map for the live frontend preview
        $types = ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'];
        $beddings = ['Single', 'Double', 'Triple', 'Quad', 'None'];

        $priceMap = [];
        foreach ($types as $type) {
            foreach ($beddings as $bed) {
                $priceMap["{$type}_{$bed}"] = 0; 
            }
        }

        // Overwrite with actual database prices
        foreach ($rooms as $room) {
            $key = $room->type . '_' . $room->bedding;
            $priceMap[$key] = $room->price;
        }

        return view('admin.room', compact('rooms', 'priceMap'));
    }

    public function store(Request $request)
    {
        // Validate inputs
        $request->validate([
            'room_no' => 'required|integer|min:1|unique:room,room_no',
            'type'    => 'required',
            'bedding' => 'required',
        ], [
            'room_no.unique' => 'This Room Number already exists in the system!',
            'room_no.integer' => 'The Room Number must be a valid whole number!'
        ]);

        // auto pricing
        $calculatedPrice = Room::calculatePrice(
            $request->input('type'), 
            $request->input('bedding')
        );

        // Save to database
        Room::create([
            'room_no' => $request->input('room_no'),
            'type'    => $request->input('type'),
            'bedding' => $request->input('bedding'),
            'price'   => $calculatedPrice,
        ]);

        return back()->with('success', 'Room added successfully!');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'type'  => 'required',
            'price' => 'required|numeric',
        ]);

        $query = Room::where('type', $request->input('type'));

        if ($request->input('bedding') !== 'Any') {
            $query->where('bedding', $request->input('bedding'));
        }

        $affectedRooms = $query->update(['price' => $request->input('price')]);

        return back()->with('success', "Success! Updated pricing for {$affectedRooms} rooms.");
    }

    public function destroy($id)
    {
        Room::where('id', $id)->delete();

        return back()->with('success', 'Room deleted!');
    }
}