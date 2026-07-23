<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird POS · Checkout #{{ $payment->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
<div class="pos-checkout">
    <div class="pos-checkout-head">
        <a href="{{ route('admin.payment') }}" class="pos-back"><i class="fa-solid fa-arrow-left"></i> Back to bills</a>
        <h2 class="pos-title">Checkout <span class="text-muted">· Invoice #{{ $payment->id }}</span></h2>
    </div>

    <div class="pos-grid">
        <!-- ORDER / BILL SUMMARY -->
        <section class="pos-card pos-order">
            <div class="pos-guest">
                <div class="pos-avatar">{{ strtoupper(substr($payment->Name,0,1)) }}</div>
                <div>
                    <div class="pos-guest-name">{{ $payment->Name }}</div>
                    <div class="pos-guest-sub">{{ $payment->Email }} · {{ $payment->RoomType }} · {{ $payment->noofdays }} night(s)</div>
                </div>
                <span class="pos-badge pos-badge-{{ $payment->status_color }} ms-auto">{{ $payment->status }}</span>
            </div>

            <ul class="pos-lines">
                <li><span>Room ({{ $payment->RoomType }})</span><span>₹{{ number_format($payment->roomtotal,2) }}</span></li>
                <li><span>Bed ({{ $payment->Bed }})</span><span>₹{{ number_format($payment->bedtotal,2) }}</span></li>
                <li><span>Meal ({{ $payment->meal }})</span><span>₹{{ number_format($payment->mealtotal,2) }}</span></li>
            </ul>

            <div class="pos-totals">
                <div class="pos-total-row"><span>Subtotal</span><span>₹{{ number_format($payment->subtotal,2) }}</span></div>
                <div class="pos-total-row"><span>Service Tax (10%)</span><span>₹{{ number_format($payment->tax_amount,2) }}</span></div>
                <div class="pos-total-row" id="row-discount"><span>Discount</span><span id="disc-display">− ₹{{ number_format($payment->discount,2) }}</span></div>
                <div class="pos-total-row pos-grand"><span>Grand Total</span><span id="grand-display">₹{{ number_format($payment->grand_total,2) }}</span></div>
                <div class="pos-total-row"><span>Already Paid</span><span>₹{{ number_format($payment->amount_paid,2) }}</span></div>
                <div class="pos-total-row pos-due"><span>Balance Due</span><span id="due-display">₹{{ number_format(max(0,$payment->balance),2) }}</span></div>
            </div>
        </section>

        <!-- PAYMENT PANEL -->
        <section class="pos-card pos-pay">
            <h3 class="pos-pay-title">Take Payment</h3>
            <form method="POST" action="{{ route('admin.payment.settle.store', $payment->id) }}" id="pay-form">
                @csrf

                <label class="pos-label">Payment Method</label>
                <div class="pos-methods">
                    <label class="pos-method"><input type="radio" name="method" value="Cash" checked><i class="fa-solid fa-money-bill-wave"></i> Cash</label>
                    <label class="pos-method"><input type="radio" name="method" value="Card"><i class="fa-solid fa-credit-card"></i> Card</label>
                    <label class="pos-method"><input type="radio" name="method" value="UPI"><i class="fa-solid fa-mobile-screen"></i> UPI</label>
                </div>

                <label class="pos-label">Discount (₹)</label>
                <input type="number" step="0.01" min="0" name="discount" id="discount" value="{{ (float)$payment->discount }}" class="pos-input">

                <label class="pos-label">Amount Received (₹)</label>
                <input type="number" step="0.01" min="0" name="amount_paid" id="amount_paid" class="pos-input pos-amount" placeholder="0.00" autofocus>

                <div class="pos-quick">
                    @foreach ([500,1000,2000,5000] as $q)
                        <button type="button" class="pos-chip" onclick="setAmt({{ $q }})">₹{{ $q }}</button>
                    @endforeach
                    <button type="button" class="pos-chip pos-chip-exact" onclick="payExact()">Exact</button>
                </div>

                <div class="pos-change">
                    <span>Change</span>
                    <span id="change-display">₹0.00</span>
                </div>

                <button type="submit" class="btn btn-success pos-confirm"><i class="fa-solid fa-check"></i> Confirm Payment</button>
            </form>
        </section>
    </div>
</div>

<script>
    const TAX = {{ \App\Models\Payment::TAX_RATE }};
    const subtotal = {{ $payment->subtotal }};
    const alreadyPaid = {{ $payment->amount_paid }};
    const tax = +(subtotal * TAX).toFixed(2);

    const discEl = document.getElementById('discount');
    const amtEl  = document.getElementById('amount_paid');

    function grand() { return Math.max(0, +(subtotal + tax - (parseFloat(discEl.value)||0)).toFixed(2)); }
    function due()   { return Math.max(0, +(grand() - alreadyPaid).toFixed(2)); }

    function recompute() {
        const g = grand();
        document.getElementById('grand-display').textContent = '₹' + g.toFixed(2);
        document.getElementById('disc-display').textContent = '− ₹' + (parseFloat(discEl.value)||0).toFixed(2);
        document.getElementById('due-display').textContent = '₹' + due().toFixed(2);
        const change = (parseFloat(amtEl.value)||0) - due();
        document.getElementById('change-display').textContent = '₹' + (change > 0 ? change : 0).toFixed(2);
    }
    function setAmt(v){ amtEl.value = ((parseFloat(amtEl.value)||0) + v).toFixed(2); recompute(); }
    function payExact(){ amtEl.value = due().toFixed(2); recompute(); }

    discEl.addEventListener('input', recompute);
    amtEl.addEventListener('input', recompute);
    recompute();
</script>
</body>
</html>
