<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="pos-wrap">
        <div class="pos-head">
            <div>
                <h2 class="pos-title">Payments &amp; Billing</h2>
                <p class="pos-sub">Settle guest bills, take payments and print receipts.</p>
            </div>
            <div class="searchsection m-0">
                <input type="text" id="search_bar" placeholder="Search guest..." onkeyup="searchFun()">
            </div>
        </div>

        <div class="roombooktable table-responsive-xl">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>Invoice</th>
                        <th>Guest</th>
                        <th>Room</th>
                        <th>Nights</th>
                        <th>Grand Total</th>
                        <th>Paid</th>
                        <th>Balance</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th class="action">Action</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($payments as $p)
                    <tr>
                        <td class="fw-semibold">#{{ $p->id }}</td>
                        <td>{{ $p->Name }}</td>
                        <td>{{ $p->RoomType }}</td>
                        <td>{{ $p->noofdays }}</td>
                        <td class="fw-semibold">₹{{ number_format($p->grand_total, 2) }}</td>
                        <td>₹{{ number_format($p->amount_paid, 2) }}</td>
                        <td class="{{ $p->balance > 0 ? 'text-danger fw-semibold' : 'text-muted' }}">₹{{ number_format(max(0,$p->balance), 2) }}</td>
                        <td>{{ $p->method ?? '—' }}</td>
                        <td><span class="pos-badge pos-badge-{{ $p->status_color }}">{{ $p->status }}</span></td>
                        <td class="action">
                            @if ($p->status !== 'Paid')
                                <a href="{{ route('admin.payment.settle', $p->id) }}"><button class="btn btn-success btn-sm"><i class="fa-solid fa-cash-register"></i> Take Payment</button></a>
                            @endif
                            <a href="{{ route('admin.payment.invoice', $p->id) }}" target="_blank"><button class="btn btn-primary btn-sm"><i class="fa-solid fa-receipt"></i> Receipt</button></a>
                            <a href="{{ route('admin.payment.delete', $p->id) }}"><button class="btn btn-danger btn-sm">Delete</button></a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center text-muted py-4">No bills yet. Confirm a booking to generate one.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    const searchFun = () => {
        let filter = document.getElementById('search_bar').value.toUpperCase();
        let tr = document.getElementById("table-data").getElementsByTagName('tr');
        for (let i = 0; i < tr.length; i++) {
            let td = tr[i].getElementsByTagName('td')[1];
            if (td) tr[i].style.display = (td.textContent || td.innerText).toUpperCase().indexOf(filter) > -1 ? "" : "none";
        }
    }
</script>
@if (session('success'))
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>swal({ title: 'Success', text: @json(session('success')), icon: 'success' });</script>
@endif
</html>
