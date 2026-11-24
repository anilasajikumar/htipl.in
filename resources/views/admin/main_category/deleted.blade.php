@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
  <h1>Deleted Categories</h1>
  <div class="ml-auto"><a href="{{route('m-category.index')}}" class="btn btn-primary">Back</a></div>
</div>
  <div class="row"><div class="col-md-12 grid-margin stretch-card"><div class="card">
  <div class="card-body"><table class="table cell-border hover stripe" id="category-table">
  <thead class="text-primary">
    <th>TYPE</th><th>CATEGORY NAME</th><th>ACTION</th>
  </thead>
  </table></div>
  </div></div></div>
</section>
</div>
<form id="edit-form" method="GET" action=""></form>
@endsection

@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#category-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('trash.main_category.data') !!}',
        columns: [
            { data: 'type', name: 'type' },
            { data: 'category_name', name: 'category_name' },
            { data: 'restore', name: 'restore', orderable: false, searchable: false }
        ]
    });
    $('body').on('click', '.deteting-btn', function(e) {
        e.preventDefault();
        if (confirm("Do You Want To Restore?")) { window.location.href = $(this).data('url'); }
    });
});
</script>
@endsection
