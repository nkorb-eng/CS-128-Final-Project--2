<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('adminassets/css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <title>BlueBird - User Dashboard</title>
</head>
<body>
   <div class="databox">
      <div class="box roombookbox">
          <h2>My Active Bookings</h2>
          <h1>{{ $activeBookingsCount }} / {{ $totalBookingsCount }}</h1>
      </div>
      <div class="box profitbox">
          <h2>Total Spent</h2>
          <h1>{{ number_format($totalSpent, 2) }} <span>$</span></h1>
      </div>
    </div>
    <div class="chartbox">
        <div class="bookroomchart">
            <canvas id="bookroomchart"></canvas>
            <h3 style="text-align: center;margin:10px 0;">Booked Room Types</h3>
        </div>
        <div class="profitchart">
            <div id="profitchart"></div>
            <h3 style="text-align: center;margin:10px 0;">Expenses History</h3>
        </div>
    </div>
</body>

<script>
    // 1. DYNAMIC DOUGHNUT CHART (Fixed hardcoded numbers)
    const labels = ['Superior Room', 'Deluxe Room', 'Guest House', 'Single Room'];
    const data = {
        labels: labels,
        datasets: [{
        label: 'My Rooms',
        backgroundColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
        ],
        borderColor: 'black',
        // Injects the real data from the controller, defaulting to 0 if empty
        data: [
            {{ $chart['Superior Room'] ?? 0 }}, 
            {{ $chart['Deluxe Room'] ?? 0 }}, 
            {{ $chart['Guest House'] ?? 0 }}, 
            {{ $chart['Single Room'] ?? 0 }}
        ],
        }]
    };

    const doughnutchart = { type: 'doughnut', data: data, options: {} };
    const myChart = new Chart(document.getElementById('bookroomchart'), doughnutchart);
</script>

<script>
    // 2. MORRIS BAR CHART (Fixed the empty data crash)
    const expenseData = @json($expenseData);

    // Only try to draw the chart if the user actually has payment data
    if (expenseData && expenseData.length > 0) {
        Morris.Bar({
            element : 'profitchart',
            data: expenseData,
            xkey:'date',
            ykeys:['spent'],
            labels:['Spent ($)'],
            hideHover:'auto',
            stacked:true,
            barColors:['rgba(153, 102, 255, 1)']
        });
    } else {
        document.getElementById('profitchart').innerHTML = 
            "<div style='display: flex; justify-content: center; align-items: center; height: 100%; color: #6c757d; font-weight: bold;'>No expenses recorded yet.</div>";
    }
</script>
</html>