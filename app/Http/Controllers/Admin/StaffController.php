<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /** List + add-staff form */
    public function index()
    {
        return view('admin.staff', [
            'staff' => Staff::all()
        ]);
    }


    public function store(Request $request)
    {
        // Check submitted data
        // dd($request->all());

        $request->validate([
            'staffname' => 'required|string|max:255',
            'staffwork' => 'required|string|max:255',
        ]);


        Staff::create([
            'name' => $request->staffname,
            'work' => $request->staffwork,
        ]);


        return redirect()
            ->route('admin.staff')
            ->with('success', 'Staff added successfully');
    }


    public function destroy($id)
    {
        Staff::where('id', $id)->delete();

        return redirect()
            ->route('admin.staff')
            ->with('success', 'Staff deleted successfully');
    }
}