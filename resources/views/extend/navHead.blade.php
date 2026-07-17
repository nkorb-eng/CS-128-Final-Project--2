<nav class="d-flex flex-row glassnav">
  <a class="navbar-brand d-flex align-items-center text-decoration-none text-dark user-select-none" href="{{ route('home') }}">
    <img class="bluebirdlogo" src="{{ asset('image/bluebirdlogo.png') }}" alt="logo" style="height: 40px; width: auto;">
    <span class="ms-2 fw-bold">BLUEBIRD</span>
  </a>

  <ul class="d-flex align-items-center list-unstyled mb-0 gap-2 gap-md-3">
    <li><a href="{{ route('home') }}" class="text-dark text-decoration-none px-1 text-nowrap firstsection">Home</a></li>
    <li><a href="#secondsection" class="text-dark text-decoration-none px-1 text-nowrap">Rooms</a></li>
    <li><a href="#thirdsection" class="text-dark text-decoration-none px-1 text-nowrap">Facilities</a></li>
    <li><a href="{{ route('contact') }}" class="text-dark text-decoration-none px-1 text-nowrap">Contact Us</a></li>

    @if(session()->has('usermail'))
      <li class="ms-1 ms-md-2">
        <a href="{{ route('user_panel') }}" class="btn btn-primary btn-sm text-nowrap">My Dashboard</a>
      </li>
      <li>
        <form action="{{ route('logout') }}" method="POST" class="m-0" style="display: inline;">
          @csrf
          <button type="submit" class="btn btn-danger btn-sm text-nowrap">Logout</button>
        </form>
      </li>
    @else
      <li class="ms-1 ms-md-2">
        <a href="{{ route('login') }}" class="btn btn-primary btn-sm text-nowrap">Login</a>
      </li>
    @endif
  </ul>
</nav>

<style>

.glassnav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    min-height: 60px;
    z-index: 200;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0px 20px;
    background: rgba(255, 255, 255, 0.44);
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(16.4px);
    -webkit-backdrop-filter: blur(16.4px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.glassnav ul {
    width: auto;
    margin: 0;
    padding: 0;
}

.glassnav ul li {
    color: black;
    text-decoration: none;
    list-style: none;
    cursor: pointer;
    position: relative;
}

.glassnav ul li a {
    text-decoration: none;
    color: black;
    cursor: pointer;
}

.glassnav ul li:hover::after {
    content: "";
    position: absolute;
    bottom: -4px;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
    height: 3px;
    background-color: black;
    transition: ease 0.3s;
}

.glassnav ul li a:hover {
    color: black;
}
</style>