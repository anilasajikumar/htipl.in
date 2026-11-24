@extends('layouts.center.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Completed Exam Students</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="students-table">
  <thead class=" text-primary">
  <th>
REGISTER NUMBER                      
  </th>
   <th>
NAME                   
  </th>
    <th>
GENDER                    
  </th>
    <th>
DOB                    
  </th>
   <th>
EMAIL                     
  </th>
     <th>
MOBILE                    
  </th>
  <th>
ADDRESS                    
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
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#students-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('completed_exam_students_data',$exam_center_id) !!}',
        columns: [
            { data: 'register_number', name: 'register_number' },
            { data: 'name', name: 'name' },
            { data: 'gender', name: 'gender' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'address', name: 'address' },
            { data: 'upload', name: 'upload', orderable: false, searchable: false },
        ],
        columnDefs:[
    {targets:3, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
  });

</script>
@endsection
