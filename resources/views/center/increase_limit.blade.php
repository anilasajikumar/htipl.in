@extends('layouts.center.layout')
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Increase Limit Of Online Course</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                <form method="POST" action="{{route('increase_limit')}}" enctype="multipart/form-data">
                    {{csrf_field()}}
                  <div class="card-body">
                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Name</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" class="form-control {{ $errors->has('course_name') ? ' is-invalid' : '' }}" name="course_name" value="{{$center_course->course_name}}" readonly>
                         <small class="text-danger">{{ $errors->first('course_name') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Validity</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="validity" id="datePickerId" required value="{{$center_course->validity}}" class="form-control {{ $errors->has('validity') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('validity') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4 d-none">
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="center_course_id" value="{{$center_course->id}}" class="form-control">
                      </div>
                    </div>

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Limit</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="limit" required value="0" class="form-control {{ $errors->has('limit') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('limit') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary" onclick="confirm('Are You Sure ? You Want to send request')">Send Request</button>
                      </div>
                    </div>
                  </div>
              </form>
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection
@section('script')
<script type="text/javascript">
datePickerId.min = new Date().toISOString().split("T")[0];
</script>
@endsection