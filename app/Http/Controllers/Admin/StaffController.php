<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /** List + add-staff form (was staff.php). */
    public function index()
    {
        return view('admin.staff', ['staff' => Staff::all()]);
    }

    public function store(Request $request)
    {
        Staff::create([
            'name' => $request->input('staffname'),
            'work' => $request->input('staffwork'),
        ]);

        return redirect()->route('admin.staff');
    }

    public function destroy($id)
    {
        Staff::where('id', $id)->delete();

        return redirect()->route('admin.staff');
    }
}
