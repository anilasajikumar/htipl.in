@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Batches</h1></div>
  <div class="col-sm-6 text-right"><a href="{{ route('batch.create') }}" class="btn btn-primary">Add Batch</a></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <table class="table cell-border hover stripe" id="batch-table">
      <thead><tr><th>TITLE</th><th>EDIT</th><th>DELETE</th></tr></thead>
    </table>
  </div></div>
</div></section>
<form id="edit-form" method="POST" action="">@csrf {{ method_field('DELETE') }}</form>
@endsection
@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#batch-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('batch_data') !!}',
        columns: [
            { data: 'title', name: 'title' },
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
