<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $payment->id }}</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <style>
        body { background: #eef2f8; padding: 30px; }
        .receipt { max-width: 480px; margin: 0 auto; background:#fff; border:1px solid var(--bb-border); border-radius: var(--bb-radius); box-shadow: var(--bb-shadow); padding: 32px; }
        .receipt h1 { text-align:center; font-family: var(--bb-serif); margin-bottom: 4px; }
        .receipt .sub { text-align:center; color: var(--bb-muted); font-size:.8rem; margin-bottom: 22px; }
        .r-row { display:flex; justify-content:space-between; padding: 7px 0; font-size:.92rem; }
        .r-row.dashed { border-top: 1px dashed var(--bb-border-2); margin-top: 6px; padding-top: 12px; }
        .r-row.grand { font-family: var(--bb-serif); font-size:1.15rem; color: var(--bb-navy); border-top: 2px solid var(--bb-navy); margin-top: 8px; padding-top: 12px; }
        .r-label { color: var(--bb-muted); }
        .r-status { text-align:center; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="receipt">
        <h1>Hotel Bluebird</h1>
        <div class="sub">RECEIPT · #{{ $payment->id }} · {{ optional($payment->paid_at)->format('d M Y') ?? $payment->cout }}</div>

        <div class="r-row"><span class="r-label">Guest</span><span>{{ $payment->Name }}</span></div>
        <div class="r-row"><span class="r-label">Room</span><span>{{ $payment->RoomType }} · {{ $payment->Bed }}</span></div>
        <div class="r-row"><span class="r-label">Stay</span><span>{{ $payment->cin }} → {{ $payment->cout }} ({{ $payment->noofdays }}n)</span></div>

        <div class="r-row dashed"><span class="r-label">Room charge</span><span>₹{{ number_format($payment->roomtotal,2) }}</span></div>
        <div class="r-row"><span class="r-label">Bed</span><span>₹{{ number_format($payment->bedtotal,2) }}</span></div>
        <div class="r-row"><span class="r-label">Meal ({{ $payment->meal }})</span><span>₹{{ number_format($payment->mealtotal,2) }}</span></div>
        <div class="r-row"><span class="r-label">Service Tax (10%)</span><span>₹{{ number_format($payment->tax_amount,2) }}</span></div>
        <div class="r-row"><span class="r-label">Discount</span><span>− ₹{{ number_format($payment->discount,2) }}</span></div>

        <div class="r-row grand"><span>Grand Total</span><span>₹{{ number_format($payment->grand_total,2) }}</span></div>
        <div class="r-row"><span class="r-label">Paid ({{ $payment->method ?? '—' }})</span><span>₹{{ number_format($payment->amount_paid,2) }}</span></div>
        <div class="r-row"><span class="r-label">Balance</span><span>₹{{ number_format(max(0,$payment->balance),2) }}</span></div>

        <div class="r-status"><span class="pos-badge pos-badge-{{ $payment->status_color }}">{{ $payment->status }}</span></div>
    </div>
</body>
</html>
