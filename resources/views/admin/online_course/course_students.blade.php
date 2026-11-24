@extends('layouts.admin.layout')
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
              <form method="get" action="{{route('online-course-students')}}">

                <div class="container-fluid bg-light ">
                  <div class="row align-items-center justify-content-center">


                    <div class="col-md-2 pt-3">
                      <div class="form-group ">
                        <label>Study Center</label>
                        <select name="study_center" id="study_center" class="form-control" required>
                          <option value="" selected>----Select----</option>
                        @foreach($study_center as $key => $value)
                        <option value="{{ $value }}">{{ $key }}</option>
                         @endforeach
                        </select>
                      </div>
                    </div>

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
                        <label>Type</label>
                        <select name="type" class="form-control">
                        <option value="" selected>----Select----</option>
                        <option value="active students">Active Students</option>
                        <option value="completed students">Completed Students</option>
                        {{-- <option value="dropped students">Dropped Students</option> --}}
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
  <div class="col-md-12">
  <div class="card">
      <div class="card-body">
      <div class="table-responsive">
      <table class="table cell-border hover stripe " id="students_table">
        <thead class=" text-primary">
          <tr>
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
            DOWNLOADS                    
              </th>
              <th>
            REG NO.                    
              </th>
              <th>
            IMAGE                    
              </th>
              <th>
            ID PROOF                    
              </th>
              <th>
            STATUS                    
              </th>
              <th>
            ACTION                    
              </th>
              @if($certificate == '1')
              <th>
            CERTIFICATE                    
              </th>
              @endif
          </tr>
        </thead>
        <tbody>
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
            <td> <a href="{{ route('files',$student->id) }}"><button class="btn btn-info">ADD</button></a></td>
            <td> <a href="{{ route('edit_register',$student->id) }}"><button class="btn btn-primary">REG NO.</button></a></td>
            <td><a href="{{asset('/storage/'.$student->image)}}" download><button class="btn btn-success">Student Image</button></a></td>
            <td><a href="{{asset('/storage/'.$student->id_proof)}}" download><button class="btn btn-warning">ID Proof Download</button></a></td>
            <td>@if($student->status == '0')<a href="{{route('student.status',$student->id)}}"><button class="btn btn-success">Unblock</button></a> @elseif($student->status == '1')<a href="{{route('student.status',$student->id)}}"><button class="btn btn-danger">Block</button></a>@endif</td>
            <td> <a href="{{ route('student.remove',$student->id) }}"><button class="btn btn-danger">Delete</button></a></td>
            @if($certificate == '1')
            <td> <a href="{{ route('online_course_certificate',$student->id) }}"><button class="btn btn-info">Download</button></a></td>
            @endif
          </tr>
            @endforeach
        </tbody>
      </table>
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
    $('#students_table').DataTable( {
    dom: 'Bfrtip',
    buttons: [ {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                } } ]
});
  });
  $(function () {
    $('#study_center').change(function(e) {
        e.preventDefault();   
        var study_center = $('#study_center').val();
        $.ajax({
            url: '/dashboard/study_center/course/'+study_center,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#course').html();
            var html = '<option value="">----Select----</option>';
            html += data;
            $('#course').html(html);
            
        })
        .fail(function() {
        })
        .always(function() {
        });
        
    });

});
</script>
@endsection