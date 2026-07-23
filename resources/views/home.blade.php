@extends('extend.app')

@include('extend.navHead')


@section('content')

  <div class="overflow-x-hidden">


    <!-- Hero Section -->
    <section class="relative h-[650px] w-full overflow-hidden">

      <div id="hotelCarousel" class="carousel slide h-full" data-bs-ride="carousel">

        <div class="carousel-inner h-full">


          <div class="carousel-item active h-full">
            <img src="{{ asset('image/hotel1.jpg') }}" class="h-[650px] w-full object-cover" alt="hotel">
          </div>


          <div class="carousel-item h-full">
            <img src="{{ asset('image/hotel2.jpg') }}" class="h-[650px] w-full object-cover" alt="hotel">
          </div>


          <div class="carousel-item h-full">
            <img src="{{ asset('image/hotel3.jpg') }}" class="h-[650px] w-full object-cover" alt="hotel">
          </div>


          <div class="carousel-item h-full">
            <img src="{{ asset('image/hotel4.jpg') }}" class="h-[650px] w-full object-cover" alt="hotel">
          </div>


        </div>


      </div>



      <!-- Overlay -->

      <div class="absolute inset-0 bg-purple-300/40"></div>



      <!-- Welcome Text -->

      <div class="absolute inset-0 flex items-center justify-center z-10">

        <h1 class="
                  text-center
                  text-6xl
                  md:text-8xl
                  font-bold
                  font-serif
                  bg-gradient-to-r
                  from-blue-600
                  to-pink-500
                  bg-clip-text
                  text-transparent
                  ">

          Welcome to heaven on earth

        </h1>


      </div>


    </section>






    <!-- Rooms Section -->

    <section class="
          min-h-[700px]
          py-20
          bg-gray-100
          ">


      <h1 class="
              text-center
              text-4xl
              font-bold
              mb-12
              ">
        ≼ Our room ≽
      </h1>




      <div class="
             
              mx-auto
              flex
              flex-wrap
              justify-center
              gap-8
              px-5
              ">



        @foreach($rooms as $room)


          <div class="
                    w-[300px]
                    bg-slate-950
                    rounded-xl
                    overflow-hidden
                    shadow-lg
                    ">


            <!-- Image -->

            <div class="relative h-[250px]">


              @if($room->image)

                <img src="{{ asset('storage/' . $room->image) }}" class="
                              w-full
                              h-[250px]
                              object-cover
                              " alt="{{ $room->type }}">

              @else

                <img src="{{ asset('image/no-room-image.jpg') }}" class="
                              w-full
                              h-[250px]
                              object-cover
                              ">

              @endif



              <div class="
                            absolute
                            bottom-3
                            right-3
                            bg-white
                            px-3
                            py-1
                            rounded-lg
                            font-bold
                            ">

                ${{number_format($room->price, 2)}}/night

              </div>


            </div>






            <!-- Room Info -->

            <div class="
                        text-center
                        p-5
                        ">


              <h2 class="
                            text-2xl
                            font-bold
                            text-blue-100
                            ">

                {{ $room->type }}

              </h2>



              <div class="
                            flex
                            justify-center
                            gap-5
                            text-gray-300
                            mt-4
                            ">

                <span>
                  <i class="fa-solid fa-door-open"></i>
                  Room {{ $room->room_no }}
                </span>


                <span>
                  <i class="fa-solid fa-bed"></i>
                  {{ $room->bedding }}
                </span>


              </div>





              <div class="
                            flex
                            justify-center
                            gap-4
                            text-white
                            mt-5
                            ">

                <i class="fa-solid fa-wifi"></i>

                <i class="fa-solid fa-utensils"></i>

                <i class="fa-solid fa-spa"></i>

                <i class="fa-solid fa-person-swimming"></i>


              </div>






              <a href="{{route('room.book', ['type' => $room->type])}}" class="
                            inline-block
                            mt-5
                            bg-blue-600
                            hover:bg-blue-700
                            text-white
                            px-5
                            py-2
                            rounded-lg
                            ">

                <i class="fa-solid fa-calendar-check"></i>

                Book Now

              </a>



            </div>



          </div>


        @endforeach


      </div>



    </section>







    <!-- Facilities -->


    <section class="
          min-h-[700px]
          py-20
          ">


      <h1 class="
              text-center
              text-4xl
              font-bold
              mb-12
              ">
        ≼ Facilities ≽
      </h1>




      <div class="
             
              mx-auto
              flex
              flex-wrap
              justify-center
              gap-8
              ">



        @php
          $facilities = [
            ['Swimming pool', 'swimingpool.jpg'],
            ['Spa', 'spa.jpg'],
            ['24*7 Restaurants', 'food.jpg'],
            ['24*7 Gym', 'gym.jpg'],
            ['Heli service', 'heli.jpg'],
          ];
        @endphp



        @foreach($facilities as $facility)

          <div class="
                    w-[250px]
                    h-[350px]
                    bg-cover
                    bg-center
                    rounded-xl
                    overflow-hidden
                    relative
                    " style="background-image:url('{{asset('image/' . $facility[1])}}')">


            <h2 class="
                        absolute
                        bottom-0
                        w-full
                        text-center
                        text-white
                        bg-black/50
                        py-3
                        font-bold
                        ">

              {{$facility[0]}}

            </h2>


          </div>


        @endforeach



      </div>


    </section>





  </div>


  @include('extend.footer')


@endsection