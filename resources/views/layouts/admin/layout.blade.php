<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name') }} | Admin</title>

  {{-- Google Font --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  {{-- Font Awesome --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  {{-- AdminLTE 3 --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  {{-- Toastr --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

  <style>
    body, .nav-sidebar .nav-link, .brand-text, .sidebar-mini .main-sidebar {
      font-family: 'Source Sans 3', 'Source Sans Pro', sans-serif;
    }
    .main-sidebar { font-size: 14px; }
    .nav-sidebar .nav-item > .nav-link { padding: .5rem .9rem; }
    .sidebar-mini.sidebar-collapse .main-sidebar .nav-link span,
    .sidebar-mini.sidebar-collapse .brand-text { display: none; }
  </style>

  @yield('style')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  {{-- ===== Top Navbar ===== --}}
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    {{-- Left links --}}
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    {{-- Right links --}}
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
          <img src="{{ asset('admin_dashboard/assets/img/avatar/avatar-1.png') }}"
               class="img-circle elevation-2 mr-2" style="width:32px;height:32px;" alt="Avatar">
          <span class="d-none d-sm-inline">{{ Auth::user()->first_name ?? 'Admin' }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="{{ route('admin.change_password') }}" class="dropdown-item">
            <i class="fas fa-key fa-sm mr-2"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="{{ route('logout') }}"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm mr-2"></i> Logout
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
        </div>
      </li>
    </ul>
  </nav>

  {{-- ===== Sidebar ===== --}}
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- Brand --}}
    <a href="{{ route('home') }}" class="brand-link">
      <i class="fas fa-graduation-cap ml-1 brand-image"></i>
      <span class="brand-text font-weight-bold ml-2">{{ config('app.name') }}</span>
    </a>

    <div class="sidebar">
      {{-- User Panel --}}
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('admin_dashboard/assets/img/avatar/avatar-1.png') }}"
               class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->first_name ?? 'Administrator' }}</a>
        </div>
      </div>

      {{-- Sidebar Menu --}}
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          {{-- Dashboard --}}
          <li class="nav-item">
            <a href="{{ route('home') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          {{-- Student Details --}}
          <li class="nav-item">
            <a href="{{ route('online.student.registerlist') }}" class="nav-link {{ Request::is('dashboard/students*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Student Details</p>
            </a>
          </li>

          {{-- Online Course --}}
          <li class="nav-item {{ Request::is('dashboard/online-course*') || Request::is('dashboard/trash/online-courses*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/online-course*') || Request::is('dashboard/trash/online-courses*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-play-circle"></i>
              <p>Online Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('online-course.create') }}" class="nav-link {{ Request::is('dashboard/online-course/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('online-course.index') }}" class="nav-link {{ Request::is('dashboard/online-course') && !Request::is('dashboard/online-course/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.online_course') }}" class="nav-link {{ Request::is('dashboard/trash/online-courses') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Courses</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Category --}}
          <li class="nav-item {{ Request::is('dashboard/category*') || Request::is('dashboard/trash/category*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/category*') || Request::is('dashboard/trash/category*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Category <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('category.create') }}" class="nav-link {{ Request::is('dashboard/category/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('category.index') }}" class="nav-link {{ Request::is('dashboard/category') && !Request::is('dashboard/category/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.category') }}" class="nav-link {{ Request::is('dashboard/trash/category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- News & Event --}}
          <li class="nav-item {{ Request::is('dashboard/news-event*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/news-event*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>News &amp; Event <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('news-event.create') }}" class="nav-link {{ Request::is('dashboard/news-event/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create News &amp; Event</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('news-event.index') }}" class="nav-link {{ Request::is('dashboard/news-event') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage News &amp; Event</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Hero Section --}}
          <li class="nav-item {{ Request::is('dashboard/hero*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/hero*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-images"></i>
              <p>Hero Section <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('hero.create') }}" class="nav-link {{ Request::is('dashboard/hero/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Hero</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('hero.index') }}" class="nav-link {{ Request::is('dashboard/hero') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Hero</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Diploma --}}
          <li class="nav-item {{ Request::is('dashboard/diploma*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/diploma*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>Diploma <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('diploma.create') }}" class="nav-link {{ Request::is('dashboard/diploma/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Register Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('diploma.index') }}" class="nav-link {{ Request::is('dashboard/diploma') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Diploma Students</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Placement --}}
          <li class="nav-item {{ Request::is('dashboard/placements*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/placements*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Placement <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('placements.create') }}" class="nav-link {{ Request::is('dashboard/placements/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Placement</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('placements.index') }}" class="nav-link {{ Request::is('dashboard/placements') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Placement</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('placements.report') }}" class="nav-link {{ Request::is('dashboard/placements/report') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Placement Applications</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Location --}}
          <li class="nav-item {{ Request::is('dashboard/location*') || Request::is('dashboard/trash/location*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/location*') || Request::is('dashboard/trash/location*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-map-marker-alt"></i>
              <p>Location <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('location.create') }}" class="nav-link {{ Request::is('dashboard/location/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Location</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('location.index') }}" class="nav-link {{ Request::is('dashboard/location') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Location</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.location') }}" class="nav-link {{ Request::is('dashboard/trash/location') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Location</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Alerts --}}
          <li class="nav-item {{ Request::is('dashboard/alert*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/alert*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-bell"></i>
              <p>Alerts <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('alert.create') }}" class="nav-link {{ Request::is('dashboard/alert/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Add Alert</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('alert.index') }}" class="nav-link {{ Request::is('dashboard/alert') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Alerts</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Testimonial --}}
          <li class="nav-item {{ Request::is('dashboard/testimonial*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/testimonial*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-quote-right"></i>
              <p>Testimonial <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('testimonial.create') }}" class="nav-link {{ Request::is('dashboard/testimonial/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Testimonial</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('testimonial.index') }}" class="nav-link {{ Request::is('dashboard/testimonial') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Testimonial</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Testimonial Videos --}}
          <li class="nav-item {{ Request::is('video-testimonial*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('video-testimonial*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-film"></i>
              <p>Testimonial Videos <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('video-testimonial.create') }}" class="nav-link {{ Request::is('video-testimonial/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Video</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('video-testimonial.index') }}" class="nav-link {{ Request::is('video-testimonial') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Videos</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Client --}}
          <li class="nav-item {{ Request::is('dashboard/client*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/client*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-handshake"></i>
              <p>Client <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('client.create') }}" class="nav-link {{ Request::is('dashboard/client/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('client.index') }}" class="nav-link {{ Request::is('dashboard/client') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Client</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Enquiry Report --}}
          <li class="nav-item">
            <a href="{{ route('enquiry.index') }}" class="nav-link {{ Request::is('enquiryreport*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Enquiry Report</p>
            </a>
          </li>

          {{-- ---- Online Course Section ---- --}}
          <li class="nav-header">ONLINE COURSE</li>

          {{-- Course Module --}}
          <li class="nav-item {{ Request::is('dashboard/course-module*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/course-module*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-th-list"></i>
              <p>Course Module <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('course-module.create') }}" class="nav-link {{ Request::is('dashboard/course-module/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Module</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('course-module.index') }}" class="nav-link {{ Request::is('dashboard/course-module') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Module</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Course Media --}}
          <li class="nav-item {{ Request::is('dashboard/course-media*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/course-media*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-video"></i>
              <p>Course Media <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('course-media.create') }}" class="nav-link {{ Request::is('dashboard/course-media/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Media</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('course-media.index') }}" class="nav-link {{ Request::is('dashboard/course-media') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Media</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Course Students --}}
          <li class="nav-item">
            <a href="{{ route('online-course-students') }}" class="nav-link {{ Request::is('dashboard/online-course-students') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users"></i>
              <p>Course Students</p>
            </a>
          </li>

          {{-- Exam --}}
          <li class="nav-item {{ Request::is('dashboard/examupload*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/examupload*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>Exam <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('examupload.create') }}" class="nav-link {{ Request::is('dashboard/examupload/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('examupload.index') }}" class="nav-link {{ Request::is('dashboard/examupload') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('examupload.report') }}" class="nav-link {{ Request::is('dashboard/examupload/report') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Exam Report</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Batch --}}
          <li class="nav-item {{ Request::is('dashboard/batch*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/batch*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Batch <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('batch.create') }}" class="nav-link {{ Request::is('dashboard/batch/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('batch.index') }}" class="nav-link {{ Request::is('dashboard/batch') && !Request::is('dashboard/batch/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Batches</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Trainor --}}
          <li class="nav-item {{ Request::is('dashboard/trainor*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/trainor*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Trainor <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('trainor.create') }}" class="nav-link {{ Request::is('dashboard/trainor/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Trainor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trainor.index') }}" class="nav-link {{ Request::is('dashboard/trainor') && !Request::is('dashboard/trainor/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Trainors</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Assessment --}}
          <li class="nav-item {{ Request::is('dashboard/assessment*') || Request::is('dashboard/assessment-submissions*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/assessment*') || Request::is('dashboard/assessment-submissions*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Assessment <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.assessment.index') }}" class="nav-link {{ Request::is('dashboard/assessment') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>All Assessments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.assessment.submissions') }}" class="nav-link {{ Request::is('dashboard/assessment-submissions') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Student Submissions</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Employees --}}
          <li class="nav-item {{ Request::is('dashboard/employees*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/employees*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Employees <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('employees.create') }}" class="nav-link {{ Request::is('dashboard/employees/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('employees.index') }}" class="nav-link {{ Request::is('dashboard/employees') && !Request::is('dashboard/employees/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Employees</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Corporate Courses Section ---- --}}
          <li class="nav-header">CORPORATE COURSES</li>

          {{-- Corporate Course --}}
          <li class="nav-item {{ Request::is('dashboard/corporate-course*') || Request::is('dashboard/trash/corporate-courses*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/corporate-course*') || Request::is('dashboard/trash/corporate-courses*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-building"></i>
              <p>Corporate Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('corporate-course.create') }}" class="nav-link {{ Request::is('dashboard/corporate-course/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('corporate-course.index') }}" class="nav-link {{ Request::is('dashboard/corporate-course') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.corporate_course') }}" class="nav-link {{ Request::is('dashboard/trash/corporate-courses') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Courses</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Corporate Categories --}}
          <li class="nav-item {{ Request::is('dashboard/corporate-category*') || Request::is('dashboard/trash/corporate-category*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/corporate-category*') || Request::is('dashboard/trash/corporate-category*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tags"></i>
              <p>Corporate Categories <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('corporate-category.create') }}" class="nav-link {{ Request::is('dashboard/corporate-category/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('corporate-category.index') }}" class="nav-link {{ Request::is('dashboard/corporate-category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.corporate-category') }}" class="nav-link {{ Request::is('dashboard/trash/corporate-category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Study Center Section ---- --}}
          <li class="nav-header">STUDY CENTER</li>

          {{-- Study Center --}}
          <li class="nav-item {{ Request::is('dashboard/center*') || Request::is('dashboard/trash/study-center*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/center*') || Request::is('dashboard/trash/study-center*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-school"></i>
              <p>Study Center <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('center.create') }}" class="nav-link {{ Request::is('dashboard/center/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Study Center</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center.index') }}" class="nav-link {{ Request::is('dashboard/center') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Study Center</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.study_center') }}" class="nav-link {{ Request::is('dashboard/trash/study-center') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Study Center</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Assign Online Course --}}
          <li class="nav-item {{ Request::is('dashboard/center-course*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/center-course*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-link"></i>
              <p>Assign Online Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('center-course.create') }}" class="nav-link {{ Request::is('dashboard/center-course/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Assign Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center-course.index') }}" class="nav-link {{ Request::is('dashboard/center-course') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Center Online Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center-course.requests') }}" class="nav-link {{ Request::is('dashboard/center-courses/requests') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Center Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center-course.trash') }}" class="nav-link {{ Request::is('dashboard/center-courses/trash') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Trash</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Downloads --}}
          <li class="nav-item {{ Request::is('dashboard/downloads*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/downloads*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-download"></i>
              <p>Downloads <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('downloads.create') }}" class="nav-link {{ Request::is('dashboard/downloads/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Add Download</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('downloads.index') }}" class="nav-link {{ Request::is('dashboard/downloads') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Downloads</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Course Calendar --}}
          <li class="nav-item {{ Request::is('dashboard/course-calender*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/course-calender*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Course Calendar <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('course-calender.create') }}" class="nav-link {{ Request::is('dashboard/course-calender/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Calendar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('course-calender.index') }}" class="nav-link {{ Request::is('dashboard/course-calender') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Calendar</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Exams Section ---- --}}
          <li class="nav-header">EXAMS</li>

          {{-- Exam --}}
          <li class="nav-item {{ Request::is('dashboard/exam*') || Request::is('dashboard/trash/exam*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/exam*') || Request::is('dashboard/trash/exam*') ? 'active' : '' }}">
              <i class="nav-icon far fa-file-alt"></i>
              <p>Exam <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('exam.create') }}" class="nav-link {{ Request::is('dashboard/exam/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('exam.index') }}" class="nav-link {{ Request::is('dashboard/exam') && !Request::is('dashboard/exam/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.exam') }}" class="nav-link {{ Request::is('dashboard/trash/exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Exams</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Assign Exams --}}
          <li class="nav-item {{ Request::is('dashboard/center-exam*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/center-exam*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Assign Exams <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('center-exam.create') }}" class="nav-link {{ Request::is('dashboard/center-exam/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Assign Exams</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center-exam.index') }}" class="nav-link {{ Request::is('dashboard/center-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Center Exams</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('center-exam.trash') }}" class="nav-link {{ Request::is('dashboard/center-exams/trash') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Trash</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Exam Registration --}}
          <li class="nav-item {{ Request::is('dashboard/pending-exam') || Request::is('dashboard/active-exam') || Request::is('dashboard/completed-exam') || Request::is('dashboard/live-exam') || Request::is('dashboard/closed-exam') || Request::is('dashboard/result-published-exam') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/pending-exam') || Request::is('dashboard/active-exam') || Request::is('dashboard/completed-exam') || Request::is('dashboard/live-exam') || Request::is('dashboard/closed-exam') || Request::is('dashboard/result-published-exam') ? 'active' : '' }}">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Exam Registration <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.pending_exam') }}" class="nav-link {{ Request::is('dashboard/pending-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Pending Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.active_exam') }}" class="nav-link {{ Request::is('dashboard/active-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Active Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.closed_exam') }}" class="nav-link {{ Request::is('dashboard/closed-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Closed Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.live_exam') }}" class="nav-link {{ Request::is('dashboard/live-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Live Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.completed_exam') }}" class="nav-link {{ Request::is('dashboard/completed-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Completed Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('admin.result_published_exam') }}" class="nav-link {{ Request::is('dashboard/result-published-exam') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Result Published</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Exam Units --}}
          <li class="nav-item {{ Request::is('dashboard/exam-unit*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/exam-unit*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Exam Units <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('exam-unit.create') }}" class="nav-link {{ Request::is('dashboard/exam-unit/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam Unit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('exam-unit.index') }}" class="nav-link {{ Request::is('dashboard/exam-unit') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam Units</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Master Document --}}
          <li class="nav-item {{ Request::is('dashboard/masterdocumentdata*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/masterdocumentdata*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Master Document <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('masterdocumentdata.create') }}" class="nav-link {{ Request::is('dashboard/masterdocumentdata/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Master Doc</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('masterdocumentdata.index') }}" class="nav-link {{ Request::is('dashboard/masterdocumentdata') && !Request::is('dashboard/masterdocumentdata/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Master Docs</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Settings Section ---- --}}
          <li class="nav-header">SETTINGS</li>

          {{-- Country --}}
          <li class="nav-item {{ Request::is('dashboard/country*') || Request::is('dashboard/trash/country*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/country*') || Request::is('dashboard/trash/country*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-globe"></i>
              <p>Country <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('country.create') }}" class="nav-link {{ Request::is('dashboard/country/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Country</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('country.index') }}" class="nav-link {{ Request::is('dashboard/country') && !Request::is('dashboard/country/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Countries</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.country') }}" class="nav-link {{ Request::is('dashboard/trash/country') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Countries</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Main Category --}}
          <li class="nav-item {{ Request::is('dashboard/m-category*') || Request::is('dashboard/main-categories*') || Request::is('dashboard/trash/main-category*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/m-category*') || Request::is('dashboard/main-categories*') || Request::is('dashboard/trash/main-category*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Main Category <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('m-category.create') }}" class="nav-link {{ Request::is('dashboard/m-category/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('m-category.index') }}" class="nav-link {{ Request::is('dashboard/m-category') && !Request::is('dashboard/m-category/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('trash.main_category') }}" class="nav-link {{ Request::is('dashboard/trash/main-category') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Website Section ---- --}}
          <li class="nav-header">WEBSITE</li>

          {{-- Footer --}}
          <li class="nav-item {{ Request::is('dashboard/footer*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/footer*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-align-center"></i>
              <p>Footer <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('footer.create') }}" class="nav-link {{ Request::is('dashboard/footer/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Add Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('footer.index') }}" class="nav-link {{ Request::is('dashboard/footer') && !Request::is('dashboard/footer/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Footer</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Announcement --}}
          <li class="nav-item">
            <a href="{{ route('announcement.index') }}" class="nav-link {{ Request::is('dashboard/announcement') ? 'active' : '' }}">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>Announcement</p>
            </a>
          </li>

          {{-- Enquiry Forms --}}
          <li class="nav-item {{ Request::is('dashboard/enquiry-form*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/enquiry-form*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Enquiry Forms <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('enquiry-form.create') }}" class="nav-link {{ Request::is('dashboard/enquiry-form/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Add Enquiry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('enquiry-form.index') }}" class="nav-link {{ Request::is('dashboard/enquiry-form') && !Request::is('dashboard/enquiry-form/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Enquiries</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- Accreditation --}}
          <li class="nav-item {{ Request::is('dashboard/accreditation*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/accreditation*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-certificate"></i>
              <p>Accreditations <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('accreditation.create') }}" class="nav-link {{ Request::is('dashboard/accreditation/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Create Accreditation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('accreditation.index') }}" class="nav-link {{ Request::is('dashboard/accreditation') && !Request::is('dashboard/accreditation/create') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Manage Accreditations</p>
                </a>
              </li>
            </ul>
          </li>

          {{-- ---- Finance Section ---- --}}
          <li class="nav-header">FINANCE</li>

          {{-- Invoice --}}
          <li class="nav-item {{ Request::is('dashboard/invoice*') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ Request::is('dashboard/invoice*') ? 'active' : '' }}">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>Invoice <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('invoice.index') }}" class="nav-link {{ Request::is('dashboard/invoice') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Student Invoices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('invoice.account.edit') }}" class="nav-link {{ Request::is('dashboard/invoice-account-setting') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i><p>Account Settings</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  {{-- ===== Content Wrapper ===== --}}
  <div class="content-wrapper">
    @yield('content')
  </div>

  {{-- ===== Footer ===== --}}
  <footer class="main-footer">
    <strong>Copyright &copy; {{ date('Y') }} <a href="#">{{ config('app.name') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 12.0
    </div>
  </footer>

</div>
{{-- /.wrapper --}}

{{-- jQuery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
{{-- Bootstrap 4 --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>
{{-- AdminLTE 3 --}}
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
{{-- Toastr --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

{!! Toastr::message() !!}

@yield('script')
</body>
</html>
