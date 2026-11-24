@extends('layouts.center.layout')
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
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="downloads-table">
  <thead class=" text-primary">
  <th>
   TITLE
  </th>
  <th>
DOWNLOAD                     
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
    $('#downloads-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('downloads-files-data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'download', name: 'download', orderable: false, searchable: false}
          
        ]
    });
  });

</script>
@endsection
