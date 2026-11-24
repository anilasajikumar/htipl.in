@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
  <h1>Deleted Countries</h1>
  <div class="ml-auto"><a href="{{route('country.index')}}" class="btn btn-primary">Back to Countries</a></div>
</div>
  <div class="row"><div class="col-md-12 grid-margin stretch-card"><div class="card">
  <div class="card-body">
  <table class="table cell-border hover stripe" id="country-table">
  <thead class="text-primary">
    <th>COUNTRY NAME</th>
    <th>ACTION</th>
  </thead>
  </table>
  </div></div></div></div>
</section>
</div>
<form id="edit-form" method="GET" action=""></form>
@endsection

@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#country-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('trash.country.data') !!}',
        columns: [
            { data: 'country', name: 'country' },
            { data: 'restore', name: 'restore', orderable: false, searchable: false }
        ]
    });
    $('body').on('click', '.deteting-btn', function(e) {
        e.preventDefault();
        if (confirm("Do You Want To Restore?")) {
            window.location.href = $(this).data('url');
        }
    });
});
</script>
@endsection
