<nav class="navbar navbar-expand navbar-light bg-light">
  <div class="container-fluid">
    <a href="/home">
      <img class="logo-img" src="{{asset('lib/images/logo.svg')}}" />
    </a>

    <div class="justify-content-right">
      {{-- Hamburguer menu --}}
      {{-- <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button> --}}
      <div class="collapse navbar-collapse" id="navbarText">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ">
          <li class="nav-item">
            <a class="nav-link" href="{{route('login')}}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('register')}}">Register</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>