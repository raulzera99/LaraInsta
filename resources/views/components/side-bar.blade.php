<aside class="sidebar">
  <header class="sidebar-header">
    <a href="{{route('home')}}">
      <img class="logo-img" src="{{asset('lib/images/logo.svg')}}" />
    </a>
    <i class="logo-icon uil uil-instagram"></i>
  </header>
  <nav class="navbar navbar-expand-lg d-flex flex-column flex-shrink-0 pb-3">
    <div class="container-fluid">
      
      <ul class="navbar-nav nav nav-pills flex-column mb-auto">
        <li class="nav-item">
          <a class="nav-link" href="{{route('home')}}">
            <button>
              <span class="text-dark">
                <i class="uil uil-estate"></i>
                <span>Home</span>
              </span>
            </button>
          </a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="">
            <button>
              <span class="text-dark">
                <i class="uil uil-search"></i>
                <span>Search</span>
              </span>
            </button>
          </a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="">
            <button>
              <span class="text-dark">
                <i class="uil uil-compass"></i>
                <span>Explore</span>
              </span>
            </button>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="" class="nav-link">
            <button>
              <span class="text-dark">
                <i class="uil uil-location-arrow">
                  <span>12</span>
                </i>
                <span>Messages</span>
              </span>
            </button>
          </a>
        </li>
  
        <li class="nav-item">
          <a href="" class="nav-link">
            <button>
              <span class="text-dark">
                <i class="uil uil-heart">
                  <em></em>
                </i>
                <span>Notifications</span>
              </span>
            </button>
          </a>
        </li>
  
  
        <li class="nav-item">
          <a href="{{route('posts.create')}}" class="nav-link">
            <button>
              <span class="text-dark">
                <i class="uil uil-plus-circle"> </i>
                <span>Create</span>
              </span>
            </button>
          </a>
        </li>
  
        <li class="nav-item pb-5">
          <a href="{{route('profiles.self')}}" class="nav-link">
            <button >
              <span class="text-dark">
                <img src="{{asset('lib/images/Profile.svg')}}" />
                <span>Profile</span>
              </span>
            </button>
          </a>
        </li>

        <li class="nav-item">
          <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link">
              <span class="text-dark">
                <i class="uil uil-signout"></i>
                <span>Logout</span>
              </span>
            </button>
          </form>
        


          {{-- <a href="{{route('logout')}}" class="nav-link">
            <button>
              <span class="text-dark">
                <i class="uil uil-signout"></i>
                <span>Logout</span>
              </span>
            </button>
          </a> --}}
        </li>
  
        {{-- <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li> --}}
  
  
        {{-- <li class="nav-item dropdown pt-5">
          <a href="/" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <button>
              <span class="text-dark">
                <i class="uil uil-bars"> </i>
                <span>More</span>
              </span>
            </button> 
          </a>
  
          <ul class="dropdown-menu">
            <li>
              <a href="#" class="dropdown-item">Settings</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Privacy</a>
            </li>
            <li>
              <a href="#" class="dropdown-item">Terms</a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a href="{{route('logout')}}" class="dropdown-item">Exit</a>
            </li>
          </ul>
  
        </li> --}}

  
  
      </ul>
    </div>
  </nav>
</aside>