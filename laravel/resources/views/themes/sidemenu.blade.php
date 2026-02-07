

<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li>
        <li class="nav-heading">Core Management</li>
        <li class="nav-item">
          <a class="nav-link collapsed" href="{{ route('semesters.index') }}">
            <i class="bi bi-book"></i>

              <span>Semester</span></i>
          </a>
          
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('student.index') }}">
                <i class="bi bi-person"></i>
                <span>Student</span></i>
            </a>
            
          </li>
         
          <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('officers.index') }}">
                <i class="bi bi-person-badge"></i>
                <span>Officer</span></i>
            </a>
            
          </li>
         
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-building"></i><span>Organization</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('courses.index') }}">
                  <i class="bi bi-circle"></i><span>List of Course</span>
                </a>
              </li>
              <li>
                <a href="{{ route('clubs.index') }}">
                  <i class="bi bi-circle"></i><span>List of Club</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-calendar"></i><span>Events</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
              <li>
                <a href="{{ route('event.index') }}">
                  <i class="bi bi-circle"></i><span>List of Event</span>
                </a>
              </li>
              <li>
                <a href="{{ route('attendance.index') }}">
                  <i class="bi bi-circle"></i><span>List of Attendance</span>
                </a>
              </li>
              <li>
                <a href="{{ route('fine.index') }}">
                  <i class="bi bi-circle"></i><span>List Absent</span>
                </a>
              </li>
              <li>
                <a href="{{ route('excused_students.index') }}">
                  <i class="bi bi-circle"></i><span>List of Excused</span>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-heading">Financial Management</li>
      <li class="nav-item">
        <a class="nav-link collapsed"  href="{{ route('contributions.index') }}">
          <i class="bi bi-journal-text"></i><span>Contribution</span>
        </a>
        
      </li><!-- End Forms Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ route('payments.index') }}">
            <i class="bi bi-currency-dollar"></i><span>Payment</span>
        </a>
    </li>
    
    <li class="nav-heading">System</li>

    <!-- Display only if user is SuperAdmin -->
    @if(auth()->user()->role == 'super-admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="{{ route('users.index') }}">
                <i class="bi bi-people"></i>
                <span>User</span>
            </a>
        </li>
    @endif
    
       
  
        <!-- End Forms Nav -->
   
  </li><!-- End Tables Nav -->
  <li class="nav-item">
    <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
      <i class="bi bi-clipboard-data"></i><span>Report</span><i class="bi bi-chevron-down ms-auto"></i>
    </a>
    <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
      <li>
        <a href="{{ route('attendance_chart') }}">
          <i class="bi bi-circle"></i><span>Chart</span>
        </a>
      </li>
      <li>
        <a href="{{ route('contributionsAndPayments') }}">
          <i class="bi bi-circle"></i><span>Contribution and Fine Report</span>
        </a>
      </li>
    
    </ul>
  </li><!-- End Icons Nav -->
    </ul>

  </aside>

  