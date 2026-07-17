<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Roombook;
use App\Models\Signup;
use App\Models\Staff;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /** Current guest's email from the session. */
    private function email(): ?string
    {
        return Session::get('usermail');
    }

    /** Panel shell with the sidebar + iframe tabs. */
    public function panel()
    {
        return view('user.user_panel');
    }

    /** Guest dashboard — their bookings, spend and charts. */
    public function dashboard()
    {
        $email = $this->email();
        $bookings = Roombook::where('Email', $email)->get();
        $payments = Payment::where('Email', $email)->get();

        $activeBookings = $bookings->where('stat', 'Confirm')->count();
        $totalBookings  = $bookings->count();
        $totalSpent     = round($payments->sum('amount_paid'), 2);
        $outstanding    = round($payments->sum(fn ($p) => max(0, $p->balance)), 2);
        $staffActive    = Staff::count();

        $chart = [
            'Superior Room' => $bookings->where('RoomType', 'Superior Room')->count(),
            'Deluxe Room'   => $bookings->where('RoomType', 'Deluxe Room')->count(),
            'Guest House'   => $bookings->where('RoomType', 'Guest House')->count(),
            'Single Room'   => $bookings->where('RoomType', 'Single Room')->count(),
        ];

        $spendData = $payments->where('amount_paid', '>', 0)
            ->groupBy(fn ($p) => optional($p->paid_at)->format('Y-m-d') ?? (string) $p->cout)
            ->map(fn ($g) => ['date' => (string) $g->first()->cout, 'spent' => round($g->sum('amount_paid'), 2)])
            ->values();

        return view('user.dashboard', compact(
            'activeBookings', 'totalBookings', 'totalSpent', 'outstanding',
            'staffActive', 'chart', 'spendData'
        ));
    }

    /** Guest's own bookings. */
    public function roombook()
    {
        return view('user.roombook', [
            'bookings' => Roombook::where('Email', $this->email())->orderByDesc('id')->get(),
        ]);
    }

    /** Guest's own bills / payments. */
    public function payment()
    {
        return view('user.payment', [
            'payments' => Payment::where('Email', $this->email())->orderByDesc('id')->get(),
        ]);
    }

    /** Guest profile from the signup record. */
    public function profile()
    {
        return view('user.userprofile', [
            'user' => Signup::where('Email', $this->email())->first(),
            'bookingCount' => Roombook::where('Email', $this->email())->count(),
        ]);
    }

    /** Guest receipt for one of their bills. */
    public function invoice($id)
    {
        $payment = Payment::where('id', $id)
            ->where('Email', $this->email())
            ->firstOrFail();

        return view('user.invoice', compact('payment'));
    }
}
