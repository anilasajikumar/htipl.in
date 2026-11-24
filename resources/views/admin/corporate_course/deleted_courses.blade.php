@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Deleted Corporate Courses</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="course-table">
  <thead class=" text-primary">
  <th>
   CATEGORY
  </th>
  <th>
   COURSE NAME
  </th>
    <th>
COURSE DURATION
  </th>
  <th>
COURSE FEE
  </th>
  <th>
ACTION
  </th>
        
  </thead>
</table>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
</section>
</div>

<form id="edit-form" method="get" action="">
@csrf
</form>
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#course-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('trash.corporate_course.data') !!}',
        columns: [
            { data: 'category', name: 'category' },
            { data: 'course_name', name: 'course_name' },
            { data: 'course_duration', name: 'course_duration' },
            { data: 'course_fee', name: 'course_fee' },
            { data: 'restore', name: 'restore', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deteting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Restore?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection
