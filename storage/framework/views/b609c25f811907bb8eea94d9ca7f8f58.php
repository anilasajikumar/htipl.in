<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?php echo e(config('app.name')); ?> | Admin</title>

  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  
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

  <?php echo $__env->yieldContent('style'); ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  
  <nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-toggle="dropdown">
          <img src="<?php echo e(asset('admin_dashboard/assets/img/avatar/avatar-1.png')); ?>"
               class="img-circle elevation-2 mr-2" style="width:32px;height:32px;" alt="Avatar">
          <span class="d-none d-sm-inline"><?php echo e(Auth::user()->first_name ?? 'Admin'); ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
          <a href="<?php echo e(route('admin.change_password')); ?>" class="dropdown-item">
            <i class="fas fa-key fa-sm mr-2"></i> Change Password
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
             onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-sm mr-2"></i> Logout
          </a>
          <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display:none;"><?php echo csrf_field(); ?></form>
        </div>
      </li>
    </ul>
  </nav>

  
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <a href="<?php echo e(route('home')); ?>" class="brand-link">
      <i class="fas fa-graduation-cap ml-1 brand-image"></i>
      <span class="brand-text font-weight-bold ml-2"><?php echo e(config('app.name')); ?></span>
    </a>

    <div class="sidebar">
      
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="<?php echo e(asset('admin_dashboard/assets/img/avatar/avatar-1.png')); ?>"
               class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo e(Auth::user()->first_name ?? 'Administrator'); ?></a>
        </div>
      </div>

      
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

          
          <li class="nav-item">
            <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(Request::is('dashboard') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="<?php echo e(route('online.student.registerlist')); ?>" class="nav-link <?php echo e(Request::is('dashboard/students*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-user-graduate"></i>
              <p>Student Details</p>
            </a>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/online-course*') || Request::is('dashboard/trash/online-courses*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/online-course*') || Request::is('dashboard/trash/online-courses*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-play-circle"></i>
              <p>Online Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('online-course.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/online-course/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('online-course.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/online-course') && !Request::is('dashboard/online-course/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.online_course')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/online-courses') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Courses</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/category*') || Request::is('dashboard/trash/category*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/category*') || Request::is('dashboard/trash/category*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Category <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('category.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/category/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('category.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/category') && !Request::is('dashboard/category/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.category')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/category') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/news-event*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/news-event*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-newspaper"></i>
              <p>News &amp; Event <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('news-event.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/news-event/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create News &amp; Event</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('news-event.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/news-event') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage News &amp; Event</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/hero*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/hero*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-images"></i>
              <p>Hero Section <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('hero.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/hero/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Hero</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('hero.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/hero') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Hero</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/diploma*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/diploma*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-graduation-cap"></i>
              <p>Diploma <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('diploma.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/diploma/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Register Student</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('diploma.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/diploma') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Diploma Students</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/placements*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/placements*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-briefcase"></i>
              <p>Placement <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('placements.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/placements/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Placement</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('placements.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/placements') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Placement</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('placements.report')); ?>" class="nav-link <?php echo e(Request::is('dashboard/placements/report') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Placement Applications</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/location*') || Request::is('dashboard/trash/location*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/location*') || Request::is('dashboard/trash/location*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-map-marker-alt"></i>
              <p>Location <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('location.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/location/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Location</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('location.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/location') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Location</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.location')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/location') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Location</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/alert*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/alert*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-bell"></i>
              <p>Alerts <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('alert.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/alert/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Add Alert</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('alert.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/alert') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Alerts</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/testimonial*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/testimonial*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-quote-right"></i>
              <p>Testimonial <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('testimonial.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/testimonial/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Testimonial</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('testimonial.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/testimonial') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Testimonial</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('video-testimonial*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('video-testimonial*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-film"></i>
              <p>Testimonial Videos <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('video-testimonial.create')); ?>" class="nav-link <?php echo e(Request::is('video-testimonial/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Video</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('video-testimonial.index')); ?>" class="nav-link <?php echo e(Request::is('video-testimonial') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Videos</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/client*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/client*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-handshake"></i>
              <p>Client <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('client.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/client/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Client</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('client.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/client') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Client</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item">
            <a href="<?php echo e(route('enquiry.index')); ?>" class="nav-link <?php echo e(Request::is('enquiryreport*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Enquiry Report</p>
            </a>
          </li>

          
          <li class="nav-header">ONLINE COURSE</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/course-module*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/course-module*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-th-list"></i>
              <p>Course Module <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('course-module.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-module/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Module</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('course-module.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-module') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Module</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/course-media*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/course-media*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-video"></i>
              <p>Course Media <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('course-media.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-media/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Media</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('course-media.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-media') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Media</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item">
            <a href="<?php echo e(route('online-course-students')); ?>" class="nav-link <?php echo e(Request::is('dashboard/online-course-students') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Course Students</p>
            </a>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/examupload*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/examupload*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-file-signature"></i>
              <p>Exam <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('examupload.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/examupload/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('examupload.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/examupload') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('examupload.report')); ?>" class="nav-link <?php echo e(Request::is('dashboard/examupload/report') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Exam Report</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/batch*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/batch*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Batch <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('batch.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/batch/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Batch</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('batch.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/batch') && !Request::is('dashboard/batch/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Batches</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/trainor*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/trainor*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-chalkboard-teacher"></i>
              <p>Trainor <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('trainor.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trainor/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Trainor</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trainor.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trainor') && !Request::is('dashboard/trainor/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Trainors</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/assessment*') || Request::is('dashboard/assessment-submissions*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/assessment*') || Request::is('dashboard/assessment-submissions*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Assessment <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('admin.assessment.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/assessment') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>All Assessments</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.assessment.submissions')); ?>" class="nav-link <?php echo e(Request::is('dashboard/assessment-submissions') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Student Submissions</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/employees*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/employees*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-users-cog"></i>
              <p>Employees <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('employees.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/employees/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Employee</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('employees.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/employees') && !Request::is('dashboard/employees/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Employees</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">CORPORATE COURSES</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/corporate-course*') || Request::is('dashboard/trash/corporate-courses*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/corporate-course*') || Request::is('dashboard/trash/corporate-courses*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-building"></i>
              <p>Corporate Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('corporate-course.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/corporate-course/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('corporate-course.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/corporate-course') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.corporate_course')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/corporate-courses') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Courses</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/corporate-category*') || Request::is('dashboard/trash/corporate-category*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/corporate-category*') || Request::is('dashboard/trash/corporate-category*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tags"></i>
              <p>Corporate Categories <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('corporate-category.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/corporate-category/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('corporate-category.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/corporate-category') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.corporate-category')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/corporate-category') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">STUDY CENTER</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/center*') || Request::is('dashboard/trash/study-center*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/center*') || Request::is('dashboard/trash/study-center*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-school"></i>
              <p>Study Center <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('center.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Study Center</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Study Center</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.study_center')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/study-center') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Study Center</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/center-course*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/center-course*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-link"></i>
              <p>Assign Online Course <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('center-course.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-course/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Assign Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center-course.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-course') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Center Online Course</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center-course.requests')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-courses/requests') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Center Requests</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center-course.trash')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-courses/trash') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Trash</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/downloads*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/downloads*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-download"></i>
              <p>Downloads <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('downloads.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/downloads/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Add Download</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('downloads.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/downloads') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Downloads</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/course-calender*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/course-calender*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>Course Calendar <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('course-calender.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-calender/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Calendar</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('course-calender.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/course-calender') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Calendar</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">EXAMS</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/exam*') || Request::is('dashboard/trash/exam*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/exam*') || Request::is('dashboard/trash/exam*') ? 'active' : ''); ?>">
              <i class="nav-icon far fa-file-alt"></i>
              <p>Exam <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('exam.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/exam/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('exam.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/exam') && !Request::is('dashboard/exam/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Exams</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/center-exam*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/center-exam*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-tasks"></i>
              <p>Assign Exams <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('center-exam.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-exam/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Assign Exams</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center-exam.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Center Exams</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('center-exam.trash')); ?>" class="nav-link <?php echo e(Request::is('dashboard/center-exams/trash') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Trash</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/pending-exam') || Request::is('dashboard/active-exam') || Request::is('dashboard/completed-exam') || Request::is('dashboard/live-exam') || Request::is('dashboard/closed-exam') || Request::is('dashboard/result-published-exam') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/pending-exam') || Request::is('dashboard/active-exam') || Request::is('dashboard/completed-exam') || Request::is('dashboard/live-exam') || Request::is('dashboard/closed-exam') || Request::is('dashboard/result-published-exam') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-clipboard-list"></i>
              <p>Exam Registration <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('admin.pending_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/pending-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Pending Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.active_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/active-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Active Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.closed_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/closed-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Closed Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.live_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/live-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Live Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.completed_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/completed-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Completed Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('admin.result_published_exam')); ?>" class="nav-link <?php echo e(Request::is('dashboard/result-published-exam') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Result Published</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/exam-unit*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/exam-unit*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>Exam Units <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('exam-unit.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/exam-unit/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Exam Unit</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('exam-unit.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/exam-unit') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Exam Units</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/masterdocumentdata*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/masterdocumentdata*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-file-invoice"></i>
              <p>Master Document <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('masterdocumentdata.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/masterdocumentdata/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Master Doc</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('masterdocumentdata.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/masterdocumentdata') && !Request::is('dashboard/masterdocumentdata/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Master Docs</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">SETTINGS</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/country*') || Request::is('dashboard/trash/country*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/country*') || Request::is('dashboard/trash/country*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-globe"></i>
              <p>Country <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('country.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/country/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Country</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('country.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/country') && !Request::is('dashboard/country/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Countries</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.country')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/country') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Countries</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/m-category*') || Request::is('dashboard/main-categories*') || Request::is('dashboard/trash/main-category*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/m-category*') || Request::is('dashboard/main-categories*') || Request::is('dashboard/trash/main-category*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-sitemap"></i>
              <p>Main Category <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('m-category.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/m-category/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('m-category.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/m-category') && !Request::is('dashboard/m-category/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('trash.main_category')); ?>" class="nav-link <?php echo e(Request::is('dashboard/trash/main-category') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Deleted Category</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">WEBSITE</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/footer*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/footer*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-align-center"></i>
              <p>Footer <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('footer.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/footer/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Add Footer</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('footer.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/footer') && !Request::is('dashboard/footer/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Footer</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item">
            <a href="<?php echo e(route('announcement.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/announcement') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-bullhorn"></i>
              <p>Announcement</p>
            </a>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/enquiry-form*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/enquiry-form*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Enquiry Forms <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('enquiry-form.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/enquiry-form/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Add Enquiry</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('enquiry-form.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/enquiry-form') && !Request::is('dashboard/enquiry-form/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Enquiries</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/accreditation*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/accreditation*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-certificate"></i>
              <p>Accreditations <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('accreditation.create')); ?>" class="nav-link <?php echo e(Request::is('dashboard/accreditation/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Create Accreditation</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('accreditation.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/accreditation') && !Request::is('dashboard/accreditation/create') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Manage Accreditations</p>
                </a>
              </li>
            </ul>
          </li>

          
          <li class="nav-header">FINANCE</li>

          
          <li class="nav-item <?php echo e(Request::is('dashboard/invoice*') ? 'menu-open' : ''); ?>">
            <a href="#" class="nav-link <?php echo e(Request::is('dashboard/invoice*') ? 'active' : ''); ?>">
              <i class="nav-icon fas fa-file-invoice-dollar"></i>
              <p>Invoice <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="<?php echo e(route('invoice.index')); ?>" class="nav-link <?php echo e(Request::is('dashboard/invoice') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Student Invoices</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="<?php echo e(route('invoice.account.edit')); ?>" class="nav-link <?php echo e(Request::is('dashboard/invoice-account-setting') ? 'active' : ''); ?>">
                  <i class="far fa-circle nav-icon"></i><p>Account Settings</p>
                </a>
              </li>
            </ul>
          </li>

        </ul>
      </nav>
    </div>
  </aside>

  
  <div class="content-wrapper">
    <?php echo $__env->yieldContent('content'); ?>
  </div>

  
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo e(date('Y')); ?> <a href="#"><?php echo e(config('app.name')); ?></a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 12.0
    </div>
  </footer>

</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php echo Toastr::message(); ?>


<?php echo $__env->yieldContent('script'); ?>
</body>
</html>
<?php /**PATH /home/sites/35a/6/6352167ba7/public_html/resources/views/layouts/admin/layout.blade.php ENDPATH**/ ?>