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

</body>
</html>
