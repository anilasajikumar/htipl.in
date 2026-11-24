@extends('layouts.admin.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Course Media</h1>
        </div>
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-12 grid-margin stretch-card">
                        <div class="card">
                            <div class='text-left'><a href="{{route('course-media.create')}}"><button class='btn w3-btn btn-success'>Add</button></a></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table cell-border hover stripe " id="course-media-table">
                                        <thead class=" text-primary">
                                            <th>
                                                Course Module
                                            </th>
                                            <th>
                                                Title
                                            </th>
                                            <th>
                                                File Type
                                            </th>
                                            <th>
                                                View
                                            </th>
                                            <th>
                                               Delete
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

<form id="edit-form" method="POST" action="">
    @csrf
    {{ method_field('DELETE') }}
</form>
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#course-media-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('course_media_data') !!}',
        columns: [
            { data: 'course_module_name', name: 'course_module_name' },
            { data: 'title', name: 'title' },
            { data: 'extension', name: 'extension' },
            { data: 'view', name: 'view', orderable: false, searchable: false},
            { data: 'action', name: 'action', orderable: false, searchable: false}
          
        ]
    });
    $('body').on('click','.deteting-btn',function(event){
      event.preventDefault();
      if (confirm("Do You Want To Delete?")) {
        var url = $(this).data('url');
      $("#edit-form").attr('action', url).submit();
    };
      
    });
  });

</script>
@endsection