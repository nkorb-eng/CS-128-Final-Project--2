<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /** List + add-room form (was room.php). */
    public function index()
    {
        return view('admin.room', ['rooms' => Room::all()]);
    }

    public function store(Request $request)
    {
        Room::create([
            'type' => $request->input('troom'),
            'bedding' => $request->input('bed'),
        ]);

        return redirect()->route('admin.room');
    }

    public function destroy($id)
    {
        Room::where('id', $id)->delete();

        return redirect()->route('admin.room');
    }
}
