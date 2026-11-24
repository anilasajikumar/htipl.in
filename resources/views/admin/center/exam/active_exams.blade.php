@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Active Exams</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="active-exam-table">
  <thead class=" text-primary">
  <th>
CENTER                      
  </th>
  <th>
EXAM                      
  </th>
  <th>
EMAIL                      
  </th>
   <th>
STUDENT COUNT                     
  </th>
   <th>
EXAM DATE                     
  </th>
     <th>
CLOSING DATE                     
  </th>
  <th>
PAYMENT DUE DATE                     
  </th>
  <th>
VIEW                     
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
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#active-exam-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('admin.active_exam_data') !!}',
        columns: [
            { data: 'study_center_name', name: 'study_center_name' },
            { data: 'exam', name: 'exam' },
            { data: 'study_center_email', name: 'study_center_email' },
            { data: 'student_exams_count', name: 'student_exams_count' },
            { data: 'date', name: 'date' },
            { data: 'closing_date', name: 'closing_date' },
            { data: 'payment_due_date', name: 'payment_due_date' },
            { data: 'view', name: 'view', orderable: false, searchable: false}
            // { data: 'live', name: 'live', orderable: false, searchable: false}

        ],
        columnDefs:[{targets:3,"defaultContent": "0"},
    {targets:4, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:5, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:6, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
  });

</script>
@endsection
