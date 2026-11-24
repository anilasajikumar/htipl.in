<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{config('app.name')}} | {{Auth::guard('center')->user()->study_center_name}}</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('center_dashboard/assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('center_dashboard/assets/css/components.css')}}">
   <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    @yield('style')
</head>

<body>

  <div id="app">
    <div class="main-wrapper">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          
          </ul>
        </form>
        <ul class="navbar-nav navbar-right">



          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{asset('center_dashboard/assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::guard('center')->user()->study_center_name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              {{-- <a href="change-password.php" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Security Settings
              </a> --}}
              <a href="{{route('study-center.change_password')}}" class="dropdown-item has-icon">
                <i class="fas fa-key"></i> Change Password
              </a>
              <div class="dropdown-divider"></div>
               <a class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"  
      onclick="event.preventDefault();  document.getElementById('logout-form').submit();"> <i class="fas fa-sign-out-alt"></i> Logout</a>
       <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
    </form>
            </div>
          </li>
        </ul>
      </nav>

      <div class="main-sidebar">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{route('study-centers')}}">{{config('app.name')}}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('study-centers')}}">{{config('app.name')}}</a>
          </div>
          <ul class="sidebar-menu">

              <li class="nav-item Active"><a class="nav-link" href="{{route('study-centers')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>

              
              <li class="menu-header">Online Course</li>

              <li class="dropdown nav-item {{ Request::is('study-center/my-course') || Request::is('study-center/*/enroll-course') || Request::is('study-center/my-course/increase-limit/*') || Request::is('study-center/online-course/active-students') || Request::is('study-center/online-course/completed-students') || Request::is('study-center/online-course/dropped-students') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>Online Course</span></a>
                <ul class="dropdown-menu">
                  <li class="nav-item {{ Request::is('study-center/my-course') ? 'active' : '' }}"><a href="{{route('my_course')}}">My Courses</a></li>
                  <li class="nav-item {{ Request::is('study-center/online-course/active-students') ? 'active' : '' }}"><a href="{{ route('active_students') }}">Active Students</a></li>
                  <li class="nav-item {{ Request::is('study-center/online-course/completed-students') ? 'active' : '' }}"><a href="{{ route('completed_students') }}">Completed Students</a></li>
                  {{-- <li class="nav-item {{ Request::is('study-center/online-course/dropped-students') ? 'active' : '' }}"><a href="{{ route('dropped_students') }}">Dropped Students</a></li> --}}
                </ul>
              </li>

             
              {{-- <li class="menu-header">Exams</li> --}}

          {{--     <li class="nav-item dropdown {{ Request::is('study-center/study-center-exam/create') ||  Request::is('study-center/study-center-exam') || Request::is('study-center/active-exam') || Request::is('study-center/closed-exam') || Request::is('study-center/completed-exam') || Request::is('study-center/live-exam') ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i> <span>Exams</span></a>
                <ul class="dropdown-menu">
                  <li class="nav-item {{ Request::is('study-center/study-center-exam/create') ? 'active' : '' }}"><a href="{{route('study-center-exam.create')}}">Create Exam</a></li>
                  <li class="nav-item {{ Request::is('study-center/study-center-exam') ? 'active' : '' }}"><a href="{{route('study-center-exam.index')}}">Pending Exams</a></li>
                  <li class="nav-item {{ Request::is('study-center/active-exam') ? 'active' : '' }}"><a href="{{route('active_exam')}}">Active Exams</a></li>
                  <li class="nav-item {{ Request::is('study-center/closed-exam') ? 'active' : '' }}"><a href="{{route('closed_exam')}}">Closed Exams</a></li>
                  <li class="nav-item {{ Request::is('study-center/live-exam') ? 'active' : '' }}"><a href="{{route('live_exam')}}">Live Exams</a></li>
                  <li class="nav-item {{ Request::is('study-center/completed-exam') ? 'active' : '' }}"><a href="{{route('completed_exam')}}">Completed Exams</a></li>
                  <li class="nav-item {{ Request::is('study-center/result-published-exam') ? 'active' : '' }}"><a href="{{route('result_published_exam')}}">Result Published Exams</a></li>
            
                </ul>
              </li> --}}

              <li class="nav-item Active"><a class="nav-link" href="{{route('downloads-files')}}"><i class="fas fa-download"></i> <span>Downloads</span></a></li>




              
             
             
            </ul>

          
        </aside>
      </div>

      <!-- Main Content -->




    </div>
  </div>


@yield('content')

  <!-- General JS Scripts -->
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script src="{{asset('center_dashboard/assets/js/stisla.js')}}"></script>

  <!-- JS Libraies -->

  <!-- Template JS File -->
  <script src="{{asset('center_dashboard/assets/js/scripts.js')}}"></script>
  <script src="{{asset('center_dashboard/assets/js/custom.js')}}"></script>
  <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>

  <!-- Page Specific JS File -->

  {!! Toastr::message() !!}

  @yield('script')

</body>
</html>
