@extends('extend.app')

@include('extend.navHead')

@section('content')
<div>
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
            <a href="{{ route('room.book', ['type' => 'Superior Room']) }}" class="btn btn-primary bookbtn">Book</a>
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
            <a href="{{ route('room.book', ['type' => 'Deluxe Room']) }}" class="btn btn-primary bookbtn">Book</a>
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
            <a href="{{ route('room.book', ['type' => 'Guest House']) }}" class="btn btn-primary bookbtn">Book</a>
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
            <a href="{{ route('room.book', ['type' => 'Single Room']) }}" class="btn btn-primary bookbtn">Book</a>
          </div>
        </div>

      </div>
    </div>
  </section>

  <section id="thirdsection" style="height: 800px;margin-top: 120px; padding-top: 120px;">
    <h1 class="head">≼ Facilities ≽</h1>
    <div class="facility">
      <div class="box"><h2>Swiming pool</h2></div>
      <div class="box"><h2>Spa</h2></div>
      <div class="box"><h2>24*7 Restaurants</h2></div>
      <div class="box"><h2>24*7 Gym</h2></div>
      <div class="box"><h2>Heli service</h2></div>
    </div>
  </section>
</div>
@include('extend.footer')
@endsection

@if (session('success'))
    <script>swal({ title: @json(session('success')), icon: 'success' });</script>
@endif
@if (session('error'))
    <script>swal({ title: @json(session('error')), icon: 'error' });</script>
@endif
</html>