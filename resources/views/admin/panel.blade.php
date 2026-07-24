<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlueBird - Admin</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    
    <link rel="stylesheet" href="{{ asset('css/flash.css') }}">
    <link rel="stylesheet" href="{{ asset('adminassets/css/admin.css') }}">
</head>

<body>
    <!-- Mobile View Alert -->
    <div id="mobileview">
        <h5>Admin panel doesn't show in mobile view</h5>
    </div>

    <!-- Upper Navbar -->
    <nav class="uppernav">
        <div class="logo">
            <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo" onerror="this.style.display='none'">
            <p>BLUEBIRD</p>
        </div>

        <!-- Header Actions (Home & Logout) -->
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" class="btn btn-light btn-sm fw-bold px-3">
                <i class="fa-solid fa-house me-1"></i> Home
            </a>
            <a href="{{ route('logout') }}" class="btn btn-danger btn-sm fw-bold px-3">
                <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
            </a>
        </div>
    </nav>

    <!-- Side Navigation -->
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><i class="fa-solid fa-chart-line me-2"></i> Dashboard</li>
            <li class="pagebtn"><i class="fa-solid fa-bed me-2"></i> Room Booking</li>
            <li class="pagebtn"><i class="fa-solid fa-wallet me-2"></i> Payment</li>
            <li class="pagebtn"><i class="fa-solid fa-door-open me-2"></i> Rooms</li>
            <li class="pagebtn"><i class="fa-solid fa-users-gear me-2"></i> Staff</li>
        </ul>
    </nav>

    <!-- Main Section with IFrames -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="{{ route('admin.dashboard') }}" frameborder="0"></iframe>
        <iframe class="frames frame2" src="{{ route('admin.roombook') }}" frameborder="0"></iframe>
        <iframe class="frames frame3" src="{{ route('admin.payment') }}" frameborder="0"></iframe>
        <iframe class="frames frame4" src="{{ route('admin.room') }}" frameborder="0"></iframe>
        <iframe class="frames frame5" src="{{ route('admin.staff') }}" frameborder="0"></iframe>
    </div>

    <script src="{{ asset('adminassets/javascript/script.js') }}"></script>
</body>
</html>