@extends('layouts.center.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
@endsection
@section('content')
      <div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Study Center Online Courses</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Study Center Online Courses</h4>
                  </div>


  <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="course-table">
  <thead class=" text-primary">
   <th>
   Course Name
  </th>
  <th>
   Validty
  </th>
    <th>
Total Limit Issued
  </th>
  <th>
Remaining Limit
  </th>
  <th>
Course Request                     
  </th>
  <th>
Register Students                    
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
          </div>
          </div>
          </div>

        </section>

      </div>

@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script>
$(function() {
    $('#course-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('my_course_data') !!}',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'validity', name: 'validity' },
            { data: null,                   
            "render": function ( data, type, row ) {
                    return (parseInt(data.student_course_count) + parseInt(data.limit));
            }
          },
            { data: 'limit', name: 'limit' },
            { data: 'request', name: 'request', orderable: false, searchable: false},
            { data: 'register', name: 'register', orderable: false, searchable: false}
          
        ],
        columnDefs:[{targets:1, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
  });

</script>
@endsection
