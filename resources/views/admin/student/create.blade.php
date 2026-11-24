@extends('layouts.admin.layout')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div class="main-content">
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
        <section class="section">
          <div class="section-header">
            <h1>Register Students To Online Course</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
               <form method="POST" action="{{ route('online.student.register') }}" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('POST')}}
                  <div class="card-body">
                      
                      
                <!--      {{-- Diploma or Certificate --}}-->
                <!--<div class="form-group row mb-4">-->
                <!--  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Type <span class="text-danger">*</span></label>-->
                <!--  <div class="col-sm-12 col-md-7">-->
                <!--    <select name="course_type" class="form-control {{ $errors->has('course_type') ? ' is-invalid' : '' }}" required>-->
                <!--      <option value="">-- Select Type --</option>-->
                <!--      <option value="Diploma" {{ old('course_type') == 'Diploma' ? 'selected' : '' }}>Diploma</option>-->
                <!--      <option value="Certificate" {{ old('course_type') == 'Certificate' ? 'selected' : '' }}>Certificate</option>-->
                <!--    </select>-->
                <!--    <small class="text-danger">{{ $errors->first('course_type') }}</small>-->
                <!--  </div>-->
                <!--</div>-->

                     <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
  <select name="course_id" class="form-control" required>
    <option value="">-- Select Course --</option>
    @foreach($courses as $course)
        <option value="{{ $course->id }}">{{ $course->course_name }}</option>
    @endforeach
</select>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Student Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="name" required class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{old('name')}}">
                        <small class="text-danger">{{ $errors->first('name') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="email" required class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{old('email')}}">
                        <small class="text-danger">{{ $errors->first('email') }}</small>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="number" name="mobile" required class="form-control {{ $errors->has('mobile') ? ' is-invalid' : '' }}" value="{{old('mobile')}}">
                        <small class="text-danger">{{ $errors->first('mobile') }}</small>
                      </div>
                    </div>
                    {{-- Father Name --}}
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Father Name <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" name="father_name" required class="form-control {{ $errors->has('father_name') ? ' is-invalid' : '' }}" value="{{ old('father_name') }}">
                        <small class="text-danger">{{ $errors->first('father_name') }}</small>
                      </div>
                    </div>
                    
                    {{-- Passout Year and Month --}}
                    <div class="form-group row mb-4">
  <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
    Passout Year and Month <span class="text-danger">*</span>
  </label>
  <div class="col-sm-12 col-md-7 d-flex gap-2">
    <select name="passout_year" class="form-control" required>
      <option value="">Select Year</option>
      @for ($year = 1980; $year <= now()->year + 5; $year++)
        <option value="{{ $year }}" {{ old('passout_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
      @endfor
    </select>

    <select name="passout_month" class="form-control" required>
      <option value="">Select Month</option>
      @for ($m = 1; $m <= 12; $m++)
        <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}" {{ old('passout_month') == str_pad($m, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
          {{ DateTime::createFromFormat('!m', $m)->format('F') }}
        </option>
      @endfor
    </select>
  </div>
</div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">DOB <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="date" name="dob" required class="form-control {{ $errors->has('dob') ? ' is-invalid' : '' }}" value="{{old('dob')}}">
                        <small class="text-danger">{{ $errors->first('dob') }}</small>
                      </div>
                    </div>
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="male" checked> Male
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="female"> Female
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="gender" value="other"> Others
                        </label>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <textarea required class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{old('address')}}" name="address">{!! old('address') !!}</textarea>
                        <small class="text-danger">{{ $errors->first('address') }}</small>
                      </div>
                    </div>

                    
                    

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="id_proof" accept="application/pdf" class="form-control">
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Image <span class="text-danger">*</span></label>
                      <div class="col-sm-12 col-md-7">
                        <input type="file" name="image" accept="image/*" class="form-control">
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button type="submit" class="btn btn-info mr-2">Submit</button>
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