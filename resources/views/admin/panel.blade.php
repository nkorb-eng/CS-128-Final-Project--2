<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('adminassets/css/admin.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/flash.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>BlueBird - Admin</title>
</head>

<body>
    <!-- mobile view -->
    <div id="mobileview">
        <h5>Admin panel doesn't show in mobile view</h5>
    </div>

    <!-- nav bar -->
    <nav class="uppernav">
        <div class="logo">
            <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo">
            <p>BLUEBIRD</p>
        </div>
        <div class="logout">
            <a href="{{ route('logout') }}"><button class="btn btn-primary">Logout</button></a>
        </div>
    </nav>
    <nav class="sidenav">
        <ul>
            <li class="pagebtn active"><img src="{{ asset('image/icon/dashboard.png') }}">&nbsp&nbsp&nbsp Dashboard</li>
            <li class="pagebtn"><img src="{{ asset('image/icon/bed.png') }}">&nbsp&nbsp&nbsp Room Booking</li>
            <li class="pagebtn"><img src="{{ asset('image/icon/wallet.png') }}">&nbsp&nbsp&nbsp Payment</li>
            <li class="pagebtn"><img src="{{ asset('image/icon/bedroom.png') }}">&nbsp&nbsp&nbsp Rooms</li>
            <li class="pagebtn"><img src="{{ asset('image/icon/staff.png') }}">&nbsp&nbsp&nbsp Staff</li>
        </ul>
    </nav>

    <!-- main section -->
    <div class="mainscreen">
        <iframe class="frames frame1 active" src="{{ route('admin.dashboard') }}" frameborder="0"></iframe>
        <iframe class="frames frame2" src="{{ route('admin.roombook') }}" frameborder="0"></iframe>
        <iframe class="frames frame3" src="{{ route('admin.payment') }}" frameborder="0"></iframe>
        <iframe class="frames frame4" src="{{ route('admin.room') }}" frameborder="0"></iframe>
        <iframe class="frames frame5" src="{{ route('admin.staff') }}" frameborder="0"></iframe>
    </div>
</body>

<script src="{{ asset('adminassets/javascript/script.js') }}"></script>

</html>
