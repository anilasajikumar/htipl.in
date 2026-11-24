@extends('layouts.center.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Students</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="dropped-students-table">
  <thead class=" text-primary">
  <th>
COURSE NAME                      
  </th>
  <th>
REGISTER NUMBER                      
  </th>
  <th>
EXAM DATE                      
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
    $('#dropped-students-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('dropped_students_data') !!}',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'register_number', name: 'register_number' },
            { data: 'exam_date', name: 'exam_date' },
            { data: 'name', name: 'name' },
            { data: 'gender', name: 'gender' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'address', name: 'address' },
        ],
        columnDefs:[
        {targets:2, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:5, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
  });

</script>
@endsection
