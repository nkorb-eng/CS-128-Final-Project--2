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
    <title>BlueBird - Admin Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
</head>
<body>
    <div class="pos-wrap">
        <h2 class="pos-title">Overview</h2>

        <div class="stat-grid">
            <div class="stat-card">
                <div class="stat-ico ico-blue"><i class="fa-solid fa-indian-rupee-sign"></i></div>
                <div><div class="stat-label">Revenue Collected</div><div class="stat-value">₹{{ number_format($revenue, 2) }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-red"><i class="fa-solid fa-hourglass-half"></i></div>
                <div><div class="stat-label">Outstanding</div><div class="stat-value">₹{{ number_format($outstanding, 2) }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-green"><i class="fa-solid fa-bed"></i></div>
                <div><div class="stat-label">Booked / Rooms</div><div class="stat-value">{{ $roombookrow }} / {{ $roomrow }}</div></div>
            </div>
            <div class="stat-card">
                <div class="stat-ico ico-navy"><i class="fa-solid fa-users"></i></div>
                <div><div class="stat-label">Staff</div><div class="stat-value">{{ $staffrow }}</div></div>
            </div>
        </div>

        <div class="stat-grid stat-grid-3">
            <div class="stat-card mini"><div class="stat-label">Paid Bills</div><div class="stat-value text-success">{{ $paidCount }}</div></div>
            <div class="stat-card mini"><div class="stat-label">Partial</div><div class="stat-value" style="color:#c98a00">{{ $partialCount }}</div></div>
            <div class="stat-card mini"><div class="stat-label">Unpaid</div><div class="stat-value text-danger">{{ $unpaidCount }}</div></div>
        </div>

        <div class="chart-grid">
            <div class="chart-card">
                <h3 class="chart-title">Booked Room Types</h3>
                <canvas id="bookroomchart"></canvas>
            </div>
            <div class="chart-card">
                <h3 class="chart-title">Revenue Collected</h3>
                <div id="revenuechart"></div>
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

    const revData = @json($revenueData);
    Morris.Bar({
        element: 'revenuechart',
        data: revData.length ? revData : [{date:'—', revenue:0}],
        xkey: 'date',
        ykeys: ['revenue'],
        labels: ['Revenue'],
        barColors: ['#2563eb'],
        hideHover: 'auto',
        gridTextColor: '#8a97ab'
    });
</script>
</html>
