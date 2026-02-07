<header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex align-items-center justify-content-between">
    <a href="{{ route('student-dashboard') }}" class="logo d-flex align-items-center">
      <img src="assets/img/csbo.jfif" alt="">
      <span class="d-none d-lg-block">CSBO </span>
    </a>
    <i class="bi bi-list toggle-sidebar-btn"></i>
  </div><!-- End Logo -->

  <div class="search-bar">
   
  </div><!-- End Search Bar -->

  <nav class="header-nav ms-auto">
    <ul class="d-flex align-items-center">

      <!-- End Search Icon-->

      

      

      </li><!-- End Notification Nav -->

      <li class="nav-item dropdown pe-3">

        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
          <img src="{{ Auth::user()->student && Auth::user()->student->picture ? asset('storage/' . Auth::user()->student->picture) : asset('assets/img/profile-img.jpg') }}" alt="Profile" class="rounded-circle">

          <span class="d-none d-md-block dropdown-toggle ps-2">{{ ucfirst(Auth::user()->student->last_name) }}</span>


        </a><!-- End Profile Iamge Icon -->

        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>{{ ucfirst(Auth::user()->student->first_name) }} {{ ucfirst(Auth::user()->student->last_name) }}</h6>
            
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

         
          <li>
            <hr class="dropdown-divider">
          </li>

  
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}" 
                      onclick="event.preventDefault(); this.closest('form').submit();">
                      <i class="bi bi-box-arrow-right"></i>
                      {{ __('Log Out') }}
                  </a>
              </form>
          </li>
          

        </ul><!-- End Profile Dropdown Items -->
      </li><!-- End Profile Nav -->

    </ul>
  </nav><!-- End Icons Navigation -->

</header>