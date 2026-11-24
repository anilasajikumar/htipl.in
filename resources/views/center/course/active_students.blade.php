@extends('layouts.center.layout')
@section('style')
<link rel="stylesheet" href="{{asset('/admin_dashboard/assets/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
@endsection
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Students</h1>
</div>
  <div class="app-content content">
  <div class="content-wrapper">
  
  <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">

              @if (count($errors)>0)
              @foreach ($errors->all() as $error)
              <div class="alert alert-danger">
                <p>{{$error}}</p>
              </div>
              @endforeach
              @endif
              <form method="get" action="{{ route('active_students') }}">

                <div class="container-fluid bg-light ">
                  <div class="row align-items-center justify-content-center">


                    <div class="col-md-2 pt-3">
                      <div class="form-group ">
                        <label>Course</label>
                        <select name="course" id="course" class="form-control">
                          <option value="" selected>----Select----</option>
                        @foreach($course as $key => $value)
                        <option value="{{ $value }}">{{ $key }}</option>
                         @endforeach
                        </select>
                      </div>
                    </div>


                    <div class="col-md-2 pt-3">
                      <div class="form-group ">
                        <label>Exam Date</label>
                        <input type="date" name="exam_date" class="form-control">
                      </div>
                    </div>

                    <div class="col-md-2 pt-3">
                      <button type="submit" class="btn btn-danger btn-block">Search</button>
                    </div>

                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
  <table class="table cell-border hover stripe " id="active-students-table">
  <thead class=" text-primary">
  <th>
COURSE NAME                      
  </th>
  <th>
REGISTER NUMBER                      
  </th>
    <th>
REG                     
  </th>
  <th>
EXAM DATE                      
  </th>
   <th>
NAME                   
  </th>
    <th>
GENDER                    
  </th>
    <th>
DOB                    
  </th>
   <th>
EMAIL                     
  </th>
     <th>
MOBILE                    
  </th>
  <th>
ADDRESS                    
  </th>
  <th>
ACTION                    
  </th>
  <th>
  IMAGE                    
  </th>
  <th>
  ID PROOF                    
  </th>
  <th>
  PASSWORD  
                 
  </th>
  <th>
       REG NO.              
  </th>
        
  </thead>
   @foreach($students as $student)
          <tr>
            <td> {{ $student->course_name }}</td>
            <td> {{ $student->register_number }}</td>
                    <td> {{ @$student->st_reg_number }}</td>
            <td> {{Carbon\Carbon::parse($student->exam_date)->format('d-m-Y')}}</td>
            <td> {{ $student->name }}</td>
            <td> {{ $student->gender }}</td>
            <td> {{Carbon\Carbon::parse($student->dob)->format('d-m-Y')}}</td>
            <td> {{ $student->email }}</td>
            <td> {{ $student->mobile }}</td>
            <td> {{ $student->address }}</td>
            <td> <a href="{{ route('center_student_files',$student->id) }}"><button class="btn btn-info">ADD</button></a></td>
            <td><a href="{{asset('/storage/'.$student->image)}}" download><button class="btn btn-success">Student Image</button></a></td>
            <td><a href="{{ asset('/storage/'.$student->id_proof) }}" download><button class="btn btn-warning">ID Proof Download</button></a></td>
            <td><a href="{{ route('student.password',$student->id) }}" class="btn btn-dark btn-fw">Change Password</a></td>
               <td><a href="{{ route('edit_student_register',$student->id) }}" class="btn btn-primary btn-fw">REG NO.</a></td>
          </tr>
            @endforeach
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
@endsection


@section('script')
<script src="{{asset('/admin_dashboard/assets/js/jquery.dataTables.min.js')}}"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>
<script>
$(function() {

  $('#active-students-table').DataTable({
        dom: 'Bfrtip',
        buttons: [ {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                } } ]
      });
      /*
    $('#active-students-table').DataTable({
        dom: 'Bfrtip',
        buttons: [ {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                } } ],
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('active_students_data') !!}',
        columns: [
            { data: 'course_name', name: 'course_name' },
            { data: 'register_number', name: 'register_number' },
            { data: 'exam_date', name: 'exam_date' },
            { data: 'name', name: 'name' },
            { data: 'gender', name: 'gender' },
            { data: 'dob', name: 'dob' },
            { data: 'email', name: 'email' },
            { data: 'mobile', name: 'mobile' },
            { data: 'address', name: 'address' },
            { data: 'file', name: 'file', orderable: false, searchable: false},
            { data: 'image', name: 'image' ,
             render: function( data, type, full, meta ) {
                        return "<img src=\"/storage/" + data + "\" height=\"50\"/>";
                    }
                },
            { data: 'id_proof', name: 'id_proof', orderable: false, searchable: false},
            { data: 'register_no', name: 'register_no', orderable: false, searchable: false},
            { data: 'change-password', name: 'change-password', orderable: false, searchable: false}
        ],
        columnDefs:[
        {targets:2, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }},
    {targets:5, render:function(data){
      return moment(data).format('DD-MM-YYYY');
    }}]
    });
    */
  });

</script>
@endsection
