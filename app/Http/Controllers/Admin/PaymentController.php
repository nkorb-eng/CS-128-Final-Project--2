<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    /** Payments table (was payment.php). */
    public function index()
    {
        return view('admin.payment', ['payments' => Payment::all()]);
    }

    public function destroy($id)
    {
        Payment::where('id', $id)->delete();

        return redirect()->route('admin.payment');
    }

    /** Printable invoice (was invoiceprint.php). */
    public function invoice($id)
    {
        $payment = Payment::where('id', $id)->firstOrFail();

        // Display-only rates used by the original invoice's "Rate" column.
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
