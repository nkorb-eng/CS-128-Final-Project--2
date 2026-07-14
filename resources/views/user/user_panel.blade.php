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
    <title>BlueBird - User Panel</title>
</head>

<body>
    <div id="mobileview">
        <h5>User panel doesn't show in mobile view</h5>
    </div>

    <nav class="uppernav">
        <div class="logo">
            <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo">
            <p>BLUEBIRD</p>
        </div>
        <div class="logout">
            <a href="{{ route('home') }}" style="color: white; text-decoration: none; margin-right: 20px;">Home</a>
            <a href="{{ route('logout') }}"><button class="btn btn-primary" style="background-color: #0d6efd; color: white; border: none; padding: 6px 12px; cursor: pointer; border-radius: 4px;">Logout</button></a>
        </div>
    </nav>

    <nav class="sidenav">
        <ul>
            <li class="user-pagebtn active" onclick="switchUserFrame(0)"><i class="fa-solid fa-gauge"></i>&nbsp&nbsp&nbsp Dashboard</li>
            <li class="user-pagebtn" onclick="switchUserFrame(1)"><i class="fa-solid fa-bed"></i>&nbsp&nbsp&nbsp Room Booking</li>
            <li class="user-pagebtn" onclick="switchUserFrame(2)"><i class="fa-solid fa-wallet"></i>&nbsp&nbsp&nbsp Payment</li>
            <li class="user-pagebtn" onclick="switchUserFrame(3)"><i class="fa-solid fa-door-open"></i>&nbsp&nbsp&nbsp Rooms</li>
            <li class="user-pagebtn" onclick="switchUserFrame(4)"><i class="fa-solid fa-file-invoice-dollar"></i>&nbsp&nbsp&nbsp Invoice</li>
        </ul>
    </nav>

    <div class="mainscreen">
        <iframe class="frames frame1 active" src="{{ route('user.dashboard') }}" frameborder="0"></iframe>
        <iframe class="frames frame2" src="{{ route('user.roombook') }}" frameborder="0"></iframe>
        <iframe class="frames frame3" src="{{ route('user.payment') }}" frameborder="0"></iframe>
        <iframe class="frames frame4" src="{{ route('user.room') }}" frameborder="0"></iframe>
        <iframe class="frames frame5" src="{{ route('user.invoice') }}" frameborder="0"></iframe>
    </div>
</body>

<script>
    function switchUserFrame(index) {
        const tabs = document.querySelectorAll('.user-pagebtn');
        tabs.forEach(tab => tab.classList.remove('active'));
        
        const frames = document.querySelectorAll('.frames');
        frames.forEach(frame => frame.classList.remove('active'));
        
        tabs[index].classList.add('active');
        frames[index].classList.add('active');
    }
</script>

</html>