@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Study Center Exams</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class='text-left'><a href="{{route('center-exam.create')}}"><button class='btn w3-btn btn-success'>Add</button></a></div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="center-exam-table">
  <thead class=" text-primary">
  <th>
   EXAM
  </th>
  <th>
   CENTER
  </th>
  <th>
UPDATE                      
  </th>
  <th>
DELETE                     
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

<form id="edit-form" method="POST" action="">
@csrf
{{ method_field('DELETE') }}
</form>
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#center-exam-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('center_exam_data') !!}',
        columns: [
            { data: 'exam', name: 'exam' },
            { data: 'center', name: 'center' },
            { data: 'edit', name: 'edit', orderable: false, searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deteting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Delete?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection
