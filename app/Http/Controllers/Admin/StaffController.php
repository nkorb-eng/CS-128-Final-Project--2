<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use Illuminate\Http\Request;

class StaffController extends Controller
{
<<<<<<< HEAD
    /** List + add-staff form (was staff.php). */
=======
    /** List + add-staff form */
>>>>>>> c0e3a935b43eba1b3dc9f1bdad6c523fe64f921a
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
