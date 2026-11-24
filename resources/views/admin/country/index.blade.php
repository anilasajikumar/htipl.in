@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
  <h1>Country</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class='text-left p-3'>
    <a href="{{route('country.create')}}"><button class='btn btn-success'>Add Country</button></a>
    <a href="{{route('trash.country')}}" class="btn btn-warning ml-2">Deleted Countries</a>
  </div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe" id="country-table">
  <thead class="text-primary">
    <th>COUNTRY</th>
    <th>UPDATE</th>
    <th>DELETE</th>
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
    $('#country-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('country_data') !!}',
        columns: [
            { data: 'country', name: 'country' },
            { data: 'edit', name: 'edit', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    $('body').on('click', '.deteting-btn', function(e) {
        e.preventDefault();
        if (confirm("Do You Want To Delete?")) {
            $("#edit-form").attr('action', $(this).data('url')).submit();
        }
    });
});
</script>
@endsection
