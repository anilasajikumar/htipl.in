@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Master Documents</h1></div>
  <div class="col-sm-6 text-right"><a href="{{ route('masterdocumentdata.create') }}" class="btn btn-primary">Add Master Document</a></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <div class="table-responsive">
      <table class="table cell-border hover stripe" id="masterdoc-table">
        <thead>
          <tr>
            <th>TITLE</th><th>CATEGORY</th><th>COURSE</th><th>TEXT</th><th>FILE</th>
            <th>STUDENT UPLOAD</th><th>DOWNLOAD</th><th>DEFAULT FILE</th><th>EDIT</th><th>DELETE</th>
          </tr>
        </thead>
      </table>
    </div>
  </div></div>
</div></section>
<form id="edit-form" method="POST" action="">@csrf {{ method_field('DELETE') }}</form>
@endsection

@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#masterdoc-table').DataTable({
        processing: true, serverSide: true, responsive: true,
        ajax: '{!! route('masterdocumentdata_data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'category_name', name: 'category_name' },
            { data: 'course_name', name: 'course_name' },
            { data: 'text', name: 'text' },
            { data: 'file', name: 'file' },
            { data: 'student_upload', name: 'student_upload' },
            { data: 'download', name: 'download' },
            { data: 'default_file_path', name: 'default_file_path', orderable: false },
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
