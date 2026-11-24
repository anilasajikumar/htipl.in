@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Accreditations</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class='text-left p-3'><a href="{{route('accreditation.create')}}"><button class='btn btn-success'>Add Accreditation</button></a></div>
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe" id="accreditation-table">
  <thead class="text-primary">
    <th>TITLE</th>
    <th>IMAGE</th>
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
    $('#accreditation-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('accreditation_data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'image', name: 'image', render: function(data) {
                return data ? '<img src="/storage/' + data + '" height="50"/>' : 'No Image';
            }},
            { data: 'edit', name: 'edit', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });
    $('body').on('click', '.deteting-btn', function(e) {
        e.preventDefault();
        if (confirm("Do You Want To Delete?")) {
            var url = $(this).data('url');
            $("#edit-form").attr('action', url).submit();
        }
    });
});
</script>
@endsection
