<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /** Display payment records */
    public function index()
    {
        $payments = Payment::orderBy('id', 'desc')->get();

        return view('admin.payment', compact('payments'));
    }

    /** Show POS checkout / settlement page */
    public function settleForm($id)
    {
        $payment = Payment::findOrFail($id);

        return view('admin.settle', compact('payment'));
    }

    /** Process POS checkout submission and update payment record */
    public function settle(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $discount = (float) $request->input('discount', 0);
        $addedPayment = (float) $request->input('amount_paid', 0);
        $method = $request->input('method', 'Cash');

        $totalPaidSoFar = (float) $payment->amount_paid + $addedPayment;

        // Calculate expected grand total and remaining balance
        $subtotal = $payment->subtotal;
        $taxAmount = $subtotal * Payment::TAX_RATE;
        $grandTotal = max(0, $subtotal + $taxAmount - $discount);
        $remainingBalance = max(0, $grandTotal - $totalPaidSoFar);

        // Determine status based on payment state
        if ($remainingBalance <= 0 || $totalPaidSoFar >= $grandTotal) {
            $status = 'Paid';
        } elseif ($totalPaidSoFar > 0) {
            $status = 'Partial';
        } else {
            $status = 'Unpaid';
        }

        $payment->discount    = $discount;
        $payment->amount_paid = $totalPaidSoFar;
        $payment->method      = $method;
        $payment->status      = $status;
        $payment->paid_at     = now();
        $payment->save();

        return redirect()->route('admin.payment')->with('success', 'Payment settled successfully!');
    }

    /** Generate and view invoice */
    public function invoice($id)
    {
        $payment = Payment::findOrFail($id);

        $days = max(1, (int) ($payment->noofdays ?? 1));
        $rooms = max(1, (int) ($payment->NoofRoom ?? 1));

        $roomRate = $days > 0 ? round(($payment->roomtotal ?? 0) / ($days * $rooms), 2) : 0;
        $bedRate = $days > 0 ? round(($payment->bedtotal ?? 0) / ($days * $rooms), 2) : 0;
        $mealRate = $days > 0 ? round(($payment->mealtotal ?? 0) / ($days * $rooms), 2) : 0;

        return view('admin.invoice', compact('payment', 'roomRate', 'bedRate', 'mealRate'));
    }

    /** Delete payment record */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return back()->with('success', 'Payment record deleted successfully!');
    }
}