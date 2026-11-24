@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Deleted Exams</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="exam-table">
  <thead class=" text-primary">
  <th>
   CATEGORY
  </th>
   <th>
   TYPE
  </th>
  <th>
   EXAM NAME
  </th>
    <th>
REGISTER BEFORE DAYS
  </th>
  <th>
EXAM FEE
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
    $('#exam-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('trash.exam.data') !!}',
        columns: [
            { data: 'category', name: 'category' },
            { data: 'type', name: 'type' },
            { data: 'exam_name', name: 'exam_name' },
            { data: 'register_before_days', name: 'register_before_days' },
            { data: 'exam_fee', name: 'exam_fee' },
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
