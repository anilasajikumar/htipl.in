@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Downloads</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class='text-left'><a href="{{route('downloads.create')}}"><button class='btn w3-btn btn-success'>Add</button></a></div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="downloads-table">
  <thead class=" text-primary">
  <th>
   TITLE
  </th>
  <th>
   VIEW
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
    $('#downloads-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('downloads_data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'view', name: 'view' },
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
