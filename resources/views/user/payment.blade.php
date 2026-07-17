<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - My Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="pos-wrap">
        <div class="pos-head">
            <div>
                <h2 class="pos-title">My Payments</h2>
                <p class="pos-sub">Your bills, balances and receipts.</p>
            </div>
        </div>

        <div class="roombooktable table-responsive-xl">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>Invoice</th><th>Room</th><th>Check In</th><th>Check Out</th>
                        <th>Grand Total</th><th>Paid</th><th>Balance</th><th>Status</th><th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td class="fw-semibold">#{{ $p->id }}</td>
                        <td>{{ $p->RoomType }}</td>
                        <td>{{ $p->cin }}</td>
                        <td>{{ $p->cout }}</td>
                        <td class="fw-semibold">₹{{ number_format($p->grand_total, 2) }}</td>
                        <td>₹{{ number_format($p->amount_paid, 2) }}</td>
                        <td class="{{ $p->balance > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">₹{{ number_format(max(0,$p->balance), 2) }}</td>
                        <td><span class="pos-badge pos-badge-{{ $p->status_color }}">{{ $p->status }}</span></td>
                        <td class="action">
                            <a href="{{ route('user.invoice', $p->id) }}" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-receipt"></i> Receipt</button></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">No bills yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
