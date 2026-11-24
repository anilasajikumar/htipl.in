@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Study Center Online Course Requests</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="center-course-table">
  <thead class=" text-primary">
  <th>
   COURSE
  </th>
  <th>
   CENTER
  </th>
    <th>
VALIDITY
  </th>
  <th>
LIMIT
  </th>
  <th>
NEW VALIDITY
  </th>
  <th>
NEW LIMIT
  </th>
  <th>
APPROVE                      
  </th>
  <th>
REJECT                     
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
    $('#center-course-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('center-course.requests.data') !!}',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'study_center_name', name: 'study_center_name' },
            { data: 'old_validity', name: 'old_validity' },
            { data: 'old_limit', name: 'old_limit' },
            { data: 'new_validity', name: 'new_validity' },
            { data: 'new_limit', name: 'new_limit' },
            { data: 'approve', name: 'approve', orderable: false, searchable: false},
            { data: 'reject', name: 'reject', orderable: false, searchable: false}
          
        ]
    });
     $('body').on('click','.reject-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Reject?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection
