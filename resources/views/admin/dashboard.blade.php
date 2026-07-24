<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('adminassets/css/dashboard.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

    <style>
        body { padding: 20px; background-color: #f4f6f9; }
        .stat-grid { display: flex; gap: 20px; margin: 20px 0; }
        .stat-card.mini { flex: 1; background: #ccdff4; padding: 15px; border-radius: 10px; display: flex; justify-content: space-between; align-items: center; }
        .chart-grid { display: flex; gap: 20px; margin-top: 20px; }
        .chart-card { flex: 1; background: #ccdff4; padding: 20px; border-radius: 10px; }
    </style>
</head>
<body>
    <div class="databox">
        <div class="box roombookbox">
            <h2>Total Booked Room</h2>
            <h1>{{ $roombookrow }} / {{ $roomrow }}</h1>
        </div>
        <div class="box guestbox">
            <h2>Total Staff</h2>
            <h1>{{ $staffrow }}</h1>
        </div>
        <div class="box profitbox">
            <h2>Profit</h2>
            <h1>${{ number_format($tot, 2) }}</h1>
        </div>
    </div>

    <div class="stat-grid">
        <div class="stat-card mini">
            <span class="fw-bold text-dark">Paid Bills</span>
            <span class="fs-4 fw-bold text-success">{{ $paidCount }}</span>
        </div>
        <div class="stat-card mini">
            <span class="fw-bold text-dark">Partial</span>
            <span class="fs-4 fw-bold" style="color:#c98a00">{{ $partialCount }}</span>
        </div>
        <div class="stat-card mini">
            <span class="fw-bold text-dark">Unpaid</span>
            <span class="fs-4 fw-bold text-danger">{{ $unpaidCount }}</span>
        </div>
    </div>

    <div class="chart-grid">
        <div class="chart-card">
            <h3 class="chart-title mb-3">Booked Room Types</h3>
            <canvas id="bookroomchart" style="max-height: 280px;"></canvas>
        </div>
        <div class="chart-card">
            <h3 class="chart-title mb-3">Revenue Collected</h3>
            <div id="revenuechart" style="height: 280px;"></div>
        </div>
    </div>

    <script>
        new Chart(document.getElementById('bookroomchart'), {
            type: 'doughnut',
            data: {
                labels: ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'],
                datasets: [{
                    data: [
                        {{ $chart['Superior Room'] ?? 0 }}, 
                        {{ $chart['Deluxe Room'] ?? 0 }}, 
                        {{ $chart['Guest House'] ?? 0 }}, 
                        {{ $chart['Single Room'] ?? 0 }}
                    ],
                    backgroundColor: ['#2563eb', '#60a5fa', '#1e40af', '#93c5fd'],
                    borderColor: '#fff', 
                    borderWidth: 2,
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
            labels: ['Revenue ($)'],
            barColors: ['#2563eb'],
            hideHover: 'auto',
            gridTextColor: '#111f49'
        });
    </script>
</body>
</html>