<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Roombook;
use App\Models\Staff;

class DashboardController extends Controller
{
    /** The admin panel shell with the iframe tabs (was admin.php). */
    public function panel()
    {
        return view('admin.panel');
    }

<<<<<<< HEAD
    /** Dashboard stats + charts (was dashboard.php). */
=======
    /** Dashboard stats + charts */
>>>>>>> c0e3a935b43eba1b3dc9f1bdad6c523fe64f921a
    public function index()
    {
        $roombookrow = Roombook::count();
        $staffrow = Staff::count();
        $roomrow = Room::count();

        $chart = [
            'Superior Room' => Roombook::where('RoomType', 'Superior Room')->count(),
            'Deluxe Room'   => Roombook::where('RoomType', 'Deluxe Room')->count(),
            'Guest House'   => Roombook::where('RoomType', 'Guest House')->count(),
            'Single Room'   => Roombook::where('RoomType', 'Single Room')->count(),
        ];

<<<<<<< HEAD
        // Morris profit chart data: 10% of each payment's final total.
        $profitData = [];
        $tot = 0;
        foreach (Payment::all() as $p) {
            $profit = $p->finaltotal * 10 / 100;
=======
        // Morris chart data
        $profitData = [];
        $tot = 0;
        foreach (Payment::all() as $p) {
            $profit = $p->finaltotal; 
>>>>>>> c0e3a935b43eba1b3dc9f1bdad6c523fe64f921a
            $profitData[] = ['date' => (string) $p->cout, 'profit' => $profit];
            $tot += $profit;
        }

        return view('admin.dashboard', compact(
            'roombookrow', 'staffrow', 'roomrow', 'chart', 'profitData', 'tot'
        ));
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> c0e3a935b43eba1b3dc9f1bdad6c523fe64f921a
