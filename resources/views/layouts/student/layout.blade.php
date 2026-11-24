<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{config('app.name')}} | {{Auth::guard('student')->user()->name}}</title>

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
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::guard('student')->user()->name}}</div></a>
            <div class="dropdown-menu dropdown-menu-right">
              {{-- <a href="change-password.php" class="dropdown-item has-icon">
                <i class="fas fa-cog"></i> Security Settings
              </a> --}}
               <a href="{{route('student.change_password')}}" class="dropdown-item has-icon">
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
            <a href="{{route('student-home')}}">{{config('app.name')}}</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="{{route('student-home')}}">{{config('app.name')}}</a>
          </div>
          <ul class="sidebar-menu">

              <li class="nav-item {{ Request::is('student/dashboard') ? 'active' : '' }}"><a class="nav-link" href="{{route('student-home')}}"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
              {{-- <li class="nav-item"><a class="nav-link" href="{{route('certificate')}}"><i class="fas fa-file"></i> <span>Certificate</span></a></li>
              <li class="nav-item"><a class="nav-link" href="{{route('student-result')}}"><i class="fas fa-file"></i> <span>Result</span></a></li> --}}
              <li class="nav-item"><a class="nav-link" href="{{route('examsattend')}}"><i class="fas fa-file"></i> <span>Attend Exam</span></a></li>
             <li class="nav-item {{ Request::is('student/files-list') ? 'active' : '' }}"><a class="nav-link" href="{{route('student-file-list')}}"><i class="fas fa-file"></i> <span>Downloads</span></a></li>
             <li class="nav-item {{ Request::is('student/student-alerts') ? 'active' : '' }}"><a class="nav-link" href="{{route('student-alerts')}}"><i class="fas fa-bell"></i> <span>Alerts</span></a></li>
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
