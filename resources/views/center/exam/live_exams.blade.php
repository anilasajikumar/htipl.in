@extends('layouts.center.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Live Exams</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="live-exam-table">
  <thead class=" text-primary">
  <th>
EXAM                      
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
DETAILS                     
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
    $('#live-exam-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('live_exam_data') !!}',
        columns: [
            { data: 'exam', name: 'exam' },
            { data: 'student_exams_count', name: 'student_exams_count' },
            { data: 'date', name: 'date' },
            { data: 'closing_date', name: 'closing_date' },
            { data: 'payment_due_date', name: 'payment_due_date' },
            { data: 'view', name: 'view', orderable: false, searchable: false}
          
        ],
        columnDefs:[{targets:1,"defaultContent": "0"},
    {targets:2, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:3, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:4, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
  });

</script>
@endsection
