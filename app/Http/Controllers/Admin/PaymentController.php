<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /** Bills / payments table. */
    public function index()
    {
        return view('admin.payment', ['payments' => Payment::orderByDesc('id')->get()]);
    }

    public function destroy($id)
    {
        Payment::where('id', $id)->delete();

        return redirect()->route('admin.payment');
    }

    /** POS checkout screen for a single bill. */
    public function settleForm($id)
    {
        return view('admin.settle', ['payment' => Payment::where('id', $id)->firstOrFail()]);
    }

    /** Record a payment against a bill (the actual point of sale). */
    public function settle(Request $request, $id)
    {
        $payment = Payment::where('id', $id)->firstOrFail();

        $payment->discount = max(0, (float) $request->input('discount', $payment->discount));

        // amount tendered is added to whatever was already paid
        $tendered = max(0, (float) $request->input('amount_paid', 0));
        $payment->amount_paid = round((float) $payment->amount_paid + $tendered, 2);
        $payment->method = $request->input('method', 'Cash');
        $payment->paid_at = now();

        // status from the outstanding balance
        $payment->status = $payment->balance <= 0 ? 'Paid'
            : ($payment->amount_paid > 0 ? 'Partial' : 'Unpaid');

        $payment->save();

        $change = $payment->balance < 0 ? number_format(abs($payment->balance), 2) : '0.00';

        return redirect()->route('admin.payment')
            ->with('success', "Payment recorded • {$payment->status} • Change ₹{$change}");
    }

    /** Printable receipt / invoice. */
    public function invoice($id)
    {
        $payment = Payment::where('id', $id)->firstOrFail();

        // Display-only per-night rates for the itemised "Rate" column.
        $roomRate = match ($payment->RoomType) {
            'Superior Room' => 320,
            'Deluxe Room'   => 220,
            'Guest House'   => 180,
            'Single Room'   => 150,
            default         => 0,
        };
        $bedRate = match ($payment->Bed) {
            'Single' => $roomRate * 1 / 100,
            'Double' => $roomRate * 2 / 100,
            'Triple' => $roomRate * 3 / 100,
            'Quad'   => $roomRate * 4 / 100,
            default  => 0,
        };
        $mealRate = match ($payment->meal) {
            'Breakfast'  => $bedRate * 2,
            'Half Board' => $bedRate * 3,
            'Full Board' => $bedRate * 4,
            default      => 0,
        };

        return view('admin.invoice', compact('payment', 'roomRate', 'bedRate', 'mealRate'));
    }
}
