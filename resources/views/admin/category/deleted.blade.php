@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Deleted Category</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="category-table">
  <thead class=" text-primary">
  <th>
   TYPE
  </th>
  <th>
   CATEGORY NAME
  </th>
    <th>
IMAGE
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
    $('#category-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('trash.category.data') !!}',
        columns: [
            { data: 'type', name: 'type' },
            { data: 'category_name', name: 'category_name' },
            { data: 'cover_image', name: 'cover_image' ,
             render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\"/>";
                    }
                },
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
