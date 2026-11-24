@extends('layouts.admin.layout')

@section('style')
<link rel="stylesheet" href="{{ asset('/admin_dashboard/assets/css/jquery.dataTables.min.css') }}">
@endsection

@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
    <h1>Hero Section</h1>
</div>

<div class="app-content content">
<div class="content-wrapper">
<div class="row">
<div class="col-md-12 grid-margin stretch-card">
<div class="card">

<div class="text-left mb-3">
    <a href="{{ route('hero.create') }}">
        <button class="btn btn-success">Add Hero</button>
    </a>
</div>

<div class="card-body">
<div class="table-responsive">
<table class="table cell-border hover stripe" id="hero-table">
<thead class="text-primary">
<tr>
    <th>TITLE</th>
    <th>SUB TITLE</th>
    <th>BACKGROUND IMAGE</th>
    <th>STATUS</th>
    <th>UPDATE</th>
    <th>DELETE</th>
</tr>
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

<form id="delete-form" method="POST" action="">
@csrf
{{ method_field('DELETE') }}
</form>
@endsection

@section('script')
<script src="{{ asset('/admin_dashboard/assets/js/jquery.dataTables.min.js') }}"></script>

<script>
$(function () {

    $('#hero-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('hero.data') !!}',
        columns: [
            { data: 'title', name: 'title' },
            { data: 'subtitle', name: 'subtitle' },
            {
                data: 'background_image',
                name: 'background_image',
                render: function (data) {
                    return '<img src="/' + data + '" height="50">';
                }
            },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    return data == 1
                        ? '<span class="badge badge-success">Active</span>'
                        : '<span class="badge badge-danger">Inactive</span>';
                }
            },
            { data: 'edit', name: 'edit', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
    });

    $('body').on('click', '.deleting-btn', function (e) {
        e.preventDefault();
        if (confirm("Do You Want To Delete?")) {
            var url = $(this).data('url');
            $('#delete-form').attr('action', url).submit();
        }
    });

});
</script>
@endsection
