<nav>
  <div class="logo">
    <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo">
    <p>BLUEBIRD</p>
  </div>
  <ul>
    <li><a href="#firstsection">Home</a></li>
    <li><a href="#secondsection">Rooms</a></li>
    <li><a href="#thirdsection">Facilities</a></li>
    <li><a href="#contactus">Contact Us</a></li>

    @if(session()->has('usermail'))
      <li>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-danger">Logout</button>
        </form>
      </li>
    @else
      <li>
        <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
      </li>
    @endif
  </ul>
</nav>