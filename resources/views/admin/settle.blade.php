<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird POS · Checkout #{{ $payment->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>

    <style>
        body { background-color: #f4f6f9; padding: 30px; font-family: 'Segoe UI', sans-serif; }
        .pos-card { background: #ffffff; border-radius: 12px; border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.05); padding: 24px; }
        .pos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; }
        @media(max-width: 992px) { .pos-grid { grid-template-columns: 1fr; } }
        .pos-avatar { width: 50px; height: 50px; border-radius: 50%; background: #0d6efd; color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 18px; }
        .pos-total-row { display: flex; justify-content: space-between; margin-bottom: 8px; color: #495057; }
        .pos-grand { font-size: 18px; font-weight: bold; color: #0d6efd; border-top: 1px solid #dee2e6; border-bottom: 1px solid #dee2e6; padding: 8px 0; margin: 12px 0; }
        .pos-due { font-size: 18px; font-weight: bold; color: #dc3545; }
        .pos-chip { background: #e9ecef; border: 1px solid #ced4da; padding: 6px 16px; border-radius: 20px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
        .pos-chip:hover { background: #0d6efd; color: white; border-color: #0d6efd; }
    </style>
</head>
<body>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.payment') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i> Back to bills</a>
        <h3 class="fw-bold text-dark m-0">POS Checkout <span class="text-muted fs-5">· Invoice #{{ $payment->id }}</span></h3>
    </div>

    <div class="pos-grid">
        <!-- ORDER SUMMARY -->
        <section class="pos-card">
            <div class="d-flex align-items-center gap-3 mb-4">
                <div class="pos-avatar">{{ strtoupper(substr($payment->Name,0,1)) }}</div>
                <div>
                    <h5 class="fw-bold m-0">{{ $payment->Name }}</h5>
                    <small class="text-muted">{{ $payment->Email }} · {{ $payment->RoomType }} · {{ $payment->noofdays }} night(s)</small>
                </div>
                <span class="badge bg-{{ $payment->status_color ?? 'secondary' }} ms-auto fs-6">{{ $payment->status }}</span>
            </div>

            <table class="table table-sm text-muted">
                <tr><td>Room Total ({{ $payment->RoomType }})</td><td class="text-end">${{ number_format($payment->roomtotal,2) }}</td></tr>
                <tr><td>Bed Total ({{ $payment->Bed }})</td><td class="text-end">${{ number_format($payment->bedtotal,2) }}</td></tr>
                <tr><td>Meal Total ({{ $payment->meal }})</td><td class="text-end">${{ number_format($payment->mealtotal,2) }}</td></tr>
            </table>

            <div class="pos-totals mt-4">
                <div class="pos-total-row"><span>Subtotal</span><span>${{ number_format($payment->subtotal,2) }}</span></div>
                <div class="pos-total-row"><span>Service Tax (10%)</span><span>${{ number_format($payment->tax_amount,2) }}</span></div>
                <div class="pos-total-row"><span>Discount</span><span id="disc-display">− ${{ number_format($payment->discount,2) }}</span></div>
                <div class="pos-total-row pos-grand"><span>Grand Total</span><span id="grand-display">${{ number_format($payment->grand_total,2) }}</span></div>
                <div class="pos-total-row"><span>Already Paid</span><span>${{ number_format($payment->amount_paid,2) }}</span></div>
                <div class="pos-total-row pos-due"><span>Balance Due</span><span id="due-display">${{ number_format(max(0,$payment->balance),2) }}</span></div>
            </div>
        </section>

        <!-- PAYMENT PANEL -->
        <section class="pos-card">
            <h4 class="fw-bold mb-4">Collect Payment</h4>
            <form method="POST" action="{{ route('admin.payment.settle.store', $payment->id) }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold small">Payment Method</label>
                    <div class="d-flex gap-2">
                        <label class="btn btn-outline-primary active flex-fill"><input type="radio" name="method" value="Cash" checked class="d-none"> <i class="fa-solid fa-money-bill-wave me-1"></i> Cash</label>
                        <label class="btn btn-outline-primary flex-fill"><input type="radio" name="method" value="Card" class="d-none"> <i class="fa-solid fa-credit-card me-1"></i> Card</label>
                        <label class="btn btn-outline-primary flex-fill"><input type="radio" name="method" value="UPI" class="d-none"> <i class="fa-solid fa-mobile-screen me-1"></i> UPI</label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Discount ($)</label>
                    <input type="number" step="0.01" min="0" name="discount" id="discount" value="{{ (float)$payment->discount }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small">Amount Received ($)</label>
                    <input type="number" step="0.01" min="0" name="amount_paid" id="amount_paid" class="form-control form-control-lg border-primary" placeholder="0.00" autofocus>
                </div>

                <div class="d-flex gap-2 mb-4">
                    @foreach ([20, 50, 100, 200] as $q)
                        <button type="button" class="pos-chip" onclick="setAmt({{ $q }})">+${{ $q }}</button>
                    @endforeach
                    <button type="button" class="pos-chip text-primary border-primary" onclick="payExact()">Exact</button>
                </div>

                <div class="p-3 bg-light rounded d-flex justify-content-between align-items-center mb-4 border">
                    <span class="fw-bold text-muted">Change Return</span>
                    <span class="fs-4 fw-bold text-success" id="change-display">$0.00</span>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100 fw-bold"><i class="fa-solid fa-check me-2"></i> Confirm Payment</button>
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
        document.getElementById('grand-display').textContent = '$' + g.toFixed(2);
        document.getElementById('disc-display').textContent = '− $' + (parseFloat(discEl.value)||0).toFixed(2);
        document.getElementById('due-display').textContent = '$' + due().toFixed(2);
        const change = (parseFloat(amtEl.value)||0) - due();
        document.getElementById('change-display').textContent = '$' + (change > 0 ? change : 0).toFixed(2);
    }
    function setAmt(v){ amtEl.value = ((parseFloat(amtEl.value)||0) + v).toFixed(2); recompute(); }
    function payExact(){ amtEl.value = due().toFixed(2); recompute(); }

    discEl.addEventListener('input', recompute);
    amtEl.addEventListener('input', recompute);
    recompute();
</script>
</body>
</html>