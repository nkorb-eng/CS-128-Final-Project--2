<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('adminassets/css/dashboard.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>BlueBird - User Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="pos-wrap">
        <h2 class="pos-title">My Overview</h2>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-ico ico-blue"><i class="fa-solid fa-calendar-check"></i></div>
                <div><div class="stat-label">Active Bookings</div><div class="stat-value">{{ $activeBookings }} / {{ $totalBookings }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-green"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                <div><div class="stat-label">Total Spent</div><div class="stat-value">₹{{ number_format($totalSpent, 2) }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-red"><i class="fa-solid fa-hourglass-half"></i></div>
                <div><div class="stat-label">Outstanding</div><div class="stat-value">₹{{ number_format($outstanding, 2) }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-navy"><i class="fa-solid fa-headset"></i></div>
                <div><div class="stat-label">Staff On Duty</div><div class="stat-value">{{ $staffActive }}</div></div>
            </div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <h3 class="chart-title">My Room Types</h3>
                <canvas id="bookroomchart"></canvas>
            </div>
            <div class="chart-card">
                <h3 class="chart-title">My Spending</h3>
                <div id="spendchart"></div>
            </div>
        </div>
    </div>
</body>

<script>
    new Chart(document.getElementById('bookroomchart'), {
        type: 'doughnut',
        data: {
            labels: ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'],
            datasets: [{
                data: [{{ $chart['Superior Room'] }}, {{ $chart['Deluxe Room'] }}, {{ $chart['Guest House'] }}, {{ $chart['Single Room'] }}],
                backgroundColor: ['#2563eb', '#60a5fa', '#1e40af', '#93c5fd'],
                borderColor: '#fff', borderWidth: 2,
            }]
        },
        options: { plugins: { legend: { position: 'bottom' } } }
    });

    const spendData = @json($spendData);
    Morris.Bar({
        element: 'spendchart',
        data: spendData.length ? spendData : [{date:'—', spent:0}],
        xkey: 'date',
        ykeys: ['spent'],
        labels: ['Spent'],
        barColors: ['#2563eb'],
        hideHover: 'auto',
        gridTextColor: '#8a97ab'
    });
</script>
</html>
