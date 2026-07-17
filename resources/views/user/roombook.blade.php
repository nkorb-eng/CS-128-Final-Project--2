<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="pos-wrap">
        <div class="pos-head">
            <div>
                <h2 class="pos-title">My Bookings</h2>
                <p class="pos-sub">All reservations linked to your account.</p>
            </div>
            <div class="searchsection m-0">
                <input type="text" id="search_bar" placeholder="Search..." onkeyup="searchFun()">
            </div>
        </div>

        <div class="roombooktable table-responsive-xl">
            <table class="table" id="table-data">
                <thead>
                    <tr>
                        <th>Id</th><th>Room</th><th>Bed</th><th>Guests</th><th>Meal</th>
                        <th>Check-In</th><th>Check-Out</th><th>Nights</th><th>Status</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($bookings as $b)
                    <tr>
                        <td class="fw-semibold">#{{ $b->id }}</td>
                        <td>{{ $b->RoomType }}</td>
                        <td>{{ $b->Bed }}</td>
                        <td>{{ $b->NoofRoom }}</td>
                        <td>{{ $b->Meal }}</td>
                        <td>{{ $b->cin }}</td>
                        <td>{{ $b->cout }}</td>
                        <td>{{ $b->nodays }}</td>
                        <td><span class="pos-badge {{ $b->stat === 'Confirm' ? 'pos-badge-success' : 'pos-badge-warning' }}">{{ $b->stat === 'Confirm' ? 'Confirmed' : 'Pending' }}</span></td>
                    </tr>
                @empty
                    <tr><td colspan="9" class="text-center text-muted py-4">You have no bookings yet.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
<script>
    const searchFun = () => {
        let f = document.getElementById('search_bar').value.toUpperCase();
        let tr = document.getElementById('table-data').getElementsByTagName('tr');
        for (let i = 0; i < tr.length; i++) { let td = tr[i].getElementsByTagName('td')[1];
            if (td) tr[i].style.display = (td.textContent||'').toUpperCase().indexOf(f) > -1 ? '' : 'none'; }
    }
</script>
</html>
