<nav>
  <a class="navbar-brand d-flex align-items-center text-decoration-none text-dark user-select-none" href="#firstsection">
    <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo" style="height: 40px; width: auto;">
    <span class="ms-2 fw-bold">BLUEBIRD</span>
  </a>
  <ul>
    <li><a href="#firstsection">Home</a></li>
    <li><a href="#secondsection">Rooms</a></li>
    <li><a href="#thirdsection">Facilities</a></li>
    <li><a href="#contactus">Contact Us</a></li>

    @if(session()->has('usermail'))
      <li class="nav-item">
        <a href="{{ route('user_panel') }}" class="btn btn-primary btn-sm">My Dashboard</a>
      </li>
      <li class="nav-item">
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm">Logout</button>
        </form>
      </li>
    @else
      <li class="nav-item">
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">Login</a>
      </li>
    @endif
  </ul>
</nav>