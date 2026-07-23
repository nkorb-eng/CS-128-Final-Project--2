<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Roombook;
use App\Models\Staff;

class DashboardController extends Controller
{
    /** The admin panel shell with the iframe tabs. */
    public function panel()
    {
        return view('admin.panel');
    }

    /** Dashboard stats + charts */
    public function index()
    {
        $roombookrow = Roombook::count();
        $staffrow = Staff::count();
        $roomrow = Room::count();

        $payments = Payment::all();

        // ---- POS money figures ----
        $revenue     = round($payments->sum('amount_paid'), 2);               // collected
        $tot         = $revenue;                                              // ✅ Alias for $tot expected in Blade view
        $outstanding = round($payments->sum(fn ($p) => max(0, $p->balance)), 2); // still owed
        $paidCount    = $payments->where('status', 'Paid')->count();
        $partialCount = $payments->where('status', 'Partial')->count();
        $unpaidCount  = $payments->where('status', 'Unpaid')->count();

        // booked-rooms doughnut
        $chart = [
            'Superior Room' => Roombook::where('RoomType', 'Superior Room')->count(),
            'Deluxe Room'   => Roombook::where('RoomType', 'Deluxe Room')->count(),
            'Guest House'   => Roombook::where('RoomType', 'Guest House')->count(),
            'Single Room'   => Roombook::where('RoomType', 'Single Room')->count(),
        ];

        // revenue-collected-over-time bar (grouped by paid date)
        $revByDate = $payments->where('amount_paid', '>', 0)
            ->groupBy(fn ($p) => optional($p->paid_at)->format('Y-m-d') ?? (string) $p->cout)
            ->map(fn ($g) => round($g->sum('amount_paid'), 2));
        $revenueData = $revByDate->map(fn ($v, $d) => ['date' => $d, 'revenue' => $v])->values();

        return view('admin.dashboard', compact(
            'roombookrow', 'staffrow', 'roomrow', 'chart',
            'revenue', 'tot', 'outstanding', 'paidCount', 'partialCount', 'unpaidCount', 'revenueData'
        ));
    }
}