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
          <a class="nav-link" href="{{route('profiles.search')}}">
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
          <a href="{{route('profiles.show', auth()->user())}}" class="nav-link">
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
        

        </li>
  
      </ul>
    </div>
  </nav>
</aside>

