<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <title>Hotel blue bird</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <link rel="stylesheet" href="{{ asset('adminassets/css/roombook.css') }}">
    <style>
      #guestdetailpanel{ display: none; }
      #guestdetailpanel .middle{ height: 450px; }
    </style>
</head>

<body>
  <nav>
    <div class="logo">
      <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo">
      <p>BLUEBIRD</p>
    </div>
    <ul>
      <li><a href="#firstsection">Home</a></li>
      <li><a href="#secondsection">Rooms</a></li>
      <li><a href="#thirdsection">Facilites</a></li>
      <li><a href="#contactus">contact us</a></li>
      <a href="{{ route('logout') }}"><button class="btn btn-danger">Logout</button></a>
    </ul>
  </nav>

  <section id="firstsection" class="carousel slide carousel_section" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="carousel-image" src="{{ asset('image/hotel1.jpg') }}">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="{{ asset('image/hotel2.jpg') }}">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="{{ asset('image/hotel3.jpg') }}">
        </div>
        <div class="carousel-item">
            <img class="carousel-image" src="{{ asset('image/hotel4.jpg') }}">
        </div>

        <div class="welcomeline">
          <h1 class="welcometag">Welcome to heaven on earth</h1>
        </div>

      <!-- bookbox -->
      <div id="guestdetailpanel">
        <form action="{{ route('home.book') }}" method="POST" class="guestdetailpanelform">
            @csrf
            <div class="head">
                <h3>RESERVATION</h3>
                <i class="fa-solid fa-circle-xmark" onclick="closebox()"></i>
            </div>
            <div class="middle">
                <div class="guestinfo">
                    <h4>Guest information</h4>
                    <input type="text" name="Name" placeholder="Enter Full name">
                    <input type="email" name="Email" placeholder="Enter Email">

                    <select name="Country" class="selectinput">
                        <option value selected>Select your country</option>
                        @foreach ($countries as $value)
                            <option value="{{ $value }}">{{ $value }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="Phone" placeholder="Enter Phoneno">
                </div>

                <div class="line"></div>

                <div class="reservationinfo">
                    <h4>Reservation information</h4>
                    <select name="RoomType" class="selectinput">
                        <option value selected>Type Of Room</option>
                        <option value="Superior Room">SUPERIOR ROOM</option>
                        <option value="Deluxe Room">DELUXE ROOM</option>
                        <option value="Guest House">GUEST HOUSE</option>
                        <option value="Single Room">SINGLE ROOM</option>
                    </select>
                    <select name="Bed" class="selectinput">
                        <option value selected>Bedding Type</option>
                        <option value="Single">Single</option>
                        <option value="Double">Double</option>
                        <option value="Triple">Triple</option>
                        <option value="Quad">Quad</option>
                        <option value="None">None</option>
                    </select>
                    <select name="NoofRoom" class="selectinput">
                        <option value selected>No of Room</option>
                        <option value="1">1</option>
                    </select>
                    <select name="Meal" class="selectinput">
                        <option value selected>Meal</option>
                        <option value="Room only">Room only</option>
                        <option value="Breakfast">Breakfast</option>
                        <option value="Half Board">Half Board</option>
                        <option value="Full Board">Full Board</option>
                    </select>
                    <div class="datesection">
                        <span>
                            <label for="cin"> Check-In</label>
                            <input name="cin" type="date">
                        </span>
                        <span>
                            <label for="cin"> Check-Out</label>
                            <input name="cout" type="date">
                        </span>
                    </div>
                </div>
            </div>
            <div class="footer">
                <button class="btn btn-success" name="guestdetailsubmit">Submit</button>
            </div>
        </form>
      </div>

    </div>
  </section>

  <section id="secondsection">
    <img src="{{ asset('image/homeanimatebg.svg') }}">
    <div class="ourroom">
      <h1 class="head">≼ Our room ≽</h1>
      <div class="roomselect">
        <div class="roombox">
          <div class="hotelphoto h1"></div>
          <div class="roomdata">
            <h2>Superior Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
              <i class="fa-solid fa-dumbbell"></i>
              <i class="fa-solid fa-person-swimming"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h2"></div>
          <div class="roomdata">
            <h2>Delux Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
              <i class="fa-solid fa-dumbbell"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h3"></div>
          <div class="roomdata">
            <h2>Guest Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
              <i class="fa-solid fa-spa"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
        <div class="roombox">
          <div class="hotelphoto h4"></div>
          <div class="roomdata">
            <h2>Single Room</h2>
            <div class="services">
              <i class="fa-solid fa-wifi"></i>
              <i class="fa-solid fa-burger"></i>
            </div>
            <button class="btn btn-primary bookbtn" onclick="openbookbox()">Book</button>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="thirdsection">
    <h1 class="head">≼ Facilities ≽</h1>
    <div class="facility">
      <div class="box"><h2>Swiming pool</h2></div>
      <div class="box"><h2>Spa</h2></div>
      <div class="box"><h2>24*7 Restaurants</h2></div>
      <div class="box"><h2>24*7 Gym</h2></div>
      <div class="box"><h2>Heli service</h2></div>
    </div>
  </section>

  <section id="contactus">
    <div class="social">
      <i class="fa-brands fa-instagram"></i>
      <i class="fa-brands fa-facebook"></i>
      <i class="fa-solid fa-envelope"></i>
    </div>
    <div class="createdby">
      <h5>Created by @tushar</h5>
    </div>
  </section>
</body>

<script>
    var bookbox = document.getElementById("guestdetailpanel");
    openbookbox = () => { bookbox.style.display = "flex"; }
    closebox = () => { bookbox.style.display = "none"; }
</script>
@if (session('success'))
    <script>swal({ title: @json(session('success')), icon: 'success' });</script>
@endif
@if (session('error'))
    <script>swal({ title: @json(session('error')), icon: 'error' });</script>
@endif
</html>
