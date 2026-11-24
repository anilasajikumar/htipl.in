@extends('layouts.admin.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Courses Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('questions.store',$course_exam->id)}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-header">
                    <h4>Create Course Exam Question</h4>
                  </div>

                  <div class="card-body">

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" value="{{$course->course_name}}" readonly>
                      </div>
                    </div>

                    {{-- <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Module</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" value="{{$course_module->course_module_name}}" readonly>
                      </div>
                    </div> --}}

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control" value="{{$course_exam->exam_name}}" readonly>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Question <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control {{ $errors->has('question') ? ' is-invalid' : '' }}" required name="question" rows="100"></textarea>
                        <small class="text-danger">{{ $errors->first('question') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image (If Any)</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="image" class="form-control {{ $errors->has('image') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('image') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Option A <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" required name="option_a" class="form-control {{ $errors->has('option_a') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('option_a') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Option B <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" required name="option_b" class="form-control {{ $errors->has('option_b') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('option_b') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Option C <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" required name="option_c" class="form-control {{ $errors->has('option_c') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('option_c') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Option D <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" required name="option_d" class="form-control {{ $errors->has('option_d') ? ' is-invalid' : '' }}">
                        <small class="text-danger">{{ $errors->first('option_d') }}</small>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Answer <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control {{ $errors->has('answer') ? ' is-invalid' : '' }} selectric" required name="answer">
                          <option value="">----Select----</option>
                          <option value="A">A</option>
                          <option value="B">B</option>
                          <option value="C">C</option>
                          <option value="D">D</option>
                        </select>
                        <small class="text-danger">{{ $errors->first('answer') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Add</button>
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Questions</h4>
                  </div>
                    <div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
  <div class="table-responsive">
                      <table class="table cell-border hover stripe " id="questions-table">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Question</th>
                            <th>Option A</th>
                            <th>Option B</th>
                            <th>Option C</th>
                            <th>Option D</th>
                            <th>Correct Answer</th>
                            <th>Image</th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>

                        {{-- <tbody>
                          <tr>
                            <td>1</td>
                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>A</td>
                            <td><img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                            </td>
                            <td><i class="fas fa-edit"> &nbsp&nbsp<i class="fas fa-trash"></i></i></td>
                          </tr>

                          <tr>
                          <td>2</td>
                            <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>magna aliqua. </td>
                            <td>A</td>
                            <td><img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle" width="35" data-toggle="tooltip" title="Wildan Ahdian">
                            </td>
                            <td><i class="fas fa-edit"> &nbsp&nbsp<i class="fas fa-trash"></i></i></td>
                          </tr>

                        </tbody> --}}
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
<form id="edit-form" method="POST" action="">
@csrf
{{ method_field('DELETE') }}
</form>

        </section>

      </div>

@endsection
@section('script')
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    $('#questions-table').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: '{!! route('questions_data',$course_exam->id) !!}',
        columns: [
        {data: 'DT_RowIndex', orderable: false, searchable: false, sortable: false},
            { data: 'question', name: 'question' },
            { data: 'option_a', name: 'option_a' },
            { data: 'option_b', name: 'option_b' },
            { data: 'option_c', name: 'option_c' },
            { data: 'option_d', name: 'option_d' },
            { data: 'answer', name: 'answer' },
            { data: 'image', name: 'image' ,
             render: function( data, type, full, meta ) {
                       if(data !== null){
                        return "<img src=\"/storage/" + data + "\" height=\"50\" alt='No Image'/>";
                    }
                    else if(data == null){
                      return 'no image';
                    }
                    }
                },
            { data: 'edit', name: 'edit', orderable: false, searchable: false},
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