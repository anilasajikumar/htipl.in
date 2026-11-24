@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header"><h1>Main Category</h1></div>
  <div class="row"><div class="col-md-12 grid-margin stretch-card"><div class="card">
  <div class='text-left p-3'>
    <a href="{{route('m-category.create')}}"><button class='btn btn-success'>Add Category</button></a>
    <a href="{{route('trash.main_category')}}" class="btn btn-warning ml-2">Deleted Categories</a>
  </div>
  <div class="card-body"><div class="table-responsive">
  <table class="table cell-border hover stripe" id="category-table">
  <thead class="text-primary">
    <th>TYPE</th><th>CATEGORY NAME</th><th>IMAGE</th><th>UPDATE</th><th>DELETE</th>
  </thead>
  </table>
  </div></div>
  </div></div></div>
</section>
</div>
<form id="edit-form" method="POST" action="">@csrf {{ method_field('DELETE') }}</form>
@endsection

@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#category-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('main_category_data') !!}',
        columns: [
            { data: 'type', name: 'type' },
            { data: 'category_name', name: 'category_name' },
            { data: 'cover_image', name: 'cover_image', render: function(data) {
                return data ? '<img src="/storage/' + data + '" height="50"/>' : 'No Image';
            }},
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
