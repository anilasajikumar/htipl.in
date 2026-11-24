@extends('layouts.admin.layout')
@section('content')
  
<div class="main-content">
    <section class="section">
          <div class="section-header">
            <h1>Study Center Online Course</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                  <form method="POST" action="{{route('center-course.store')}}" enctype="multipart/form-data">
  {{csrf_field()}}
                  <div class="card-header">
                    <h4>Assign Online Course</h4>
                  </div>

                  <div class="card-body">

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Online Course <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric {{ $errors->has('course') ? ' is-invalid' : '' }}" name="course" required>
                          <option value="">----Select----</option>
                          @foreach($course as $key => $value)
                          <option value="{{$value}}">{{$key}}</option>
                          @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('course') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Study Center <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric {{ $errors->has('center') ? ' is-invalid' : '' }}" name="center" required>
                          <option value="">----Select----</option>
                           @foreach($center as $key => $value)
                          <option value="{{$value}}">{{$key}}</option>
                          @endforeach
                        </select>
                          <small class="text-danger">{{ $errors->first('center') }}</small>
                      </div>
                    </div>

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Validity <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" id="datePickerId" name="validity" required value="{{old('validity')}}" class="form-control {{ $errors->has('validity') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('validity') }}</small>
                      </div>
                    </div>

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Limit <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="limit" min="0" required value="{{old('limit')}}" class="form-control {{ $errors->has('limit') ? ' is-invalid' : '' }}">
                          <small class="text-danger">{{ $errors->first('limit') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Submit</button>
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
