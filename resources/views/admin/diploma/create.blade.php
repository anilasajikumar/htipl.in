@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Register Diploma Student</h1>
            <div class="section-header-button">
                <a href="{{ route('diploma.index') }}" class="btn btn-secondary">Back to List</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('diploma.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">

                            {{-- Course --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Course <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <select name="course_id" class="form-control {{ $errors->has('course_id') ? 'is-invalid' : '' }}" required>
                                        <option value="">-- Select Course --</option>
                                        @foreach($courses as $course)
                                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                {{ $course->course_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small class="text-danger">{{ $errors->first('course_id') }}</small>
                                </div>
                            </div>

                            {{-- Student Name --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Student Name <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name="name" required class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                                    <small class="text-danger">{{ $errors->first('name') }}</small>
                                </div>
                            </div>

                            {{-- Father Name --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Father Name <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name="father_name" required class="form-control {{ $errors->has('father_name') ? 'is-invalid' : '' }}" value="{{ old('father_name') }}">
                                    <small class="text-danger">{{ $errors->first('father_name') }}</small>
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Email <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="email" name="email" required class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email') }}">
                                    <small class="text-danger">{{ $errors->first('email') }}</small>
                                </div>
                            </div>

                            {{-- Mobile --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Mobile <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="number" name="mobile" required class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" value="{{ old('mobile') }}">
                                    <small class="text-danger">{{ $errors->first('mobile') }}</small>
                                </div>
                            </div>

                            {{-- DOB --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date of Birth <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="date" name="dob" required class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}" value="{{ old('dob') }}">
                                    <small class="text-danger">{{ $errors->first('dob') }}</small>
                                </div>
                            </div>

                            {{-- Gender --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Gender <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7 pt-2">
                                    <label class="radio-inline mr-3"><input type="radio" name="gender" value="male" {{ old('gender','male') == 'male' ? 'checked' : '' }}> Male</label>
                                    <label class="radio-inline mr-3"><input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Female</label>
                                    <label class="radio-inline"><input type="radio" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}> Others</label>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea required name="address" class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}">{{ old('address') }}</textarea>
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                </div>
                            </div>

                            {{-- Passout Year & Month --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Passout Year & Month <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7 d-flex" style="gap:10px">
                                    <select name="passout_year" class="form-control" required>
                                        <option value="">Year</option>
                                        @for($y = 1980; $y <= now()->year + 5; $y++)
                                            <option value="{{ $y }}" {{ old('passout_year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                                        @endfor
                                    </select>
                                    <select name="passout_month" class="form-control" required>
                                        <option value="">Month</option>
                                        @for($m = 1; $m <= 12; $m++)
                                            <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}" {{ old('passout_month') == str_pad($m,2,'0',STR_PAD_LEFT) ? 'selected' : '' }}>
                                                {{ DateTime::createFromFormat('!m',$m)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-12 col-md-7 offset-md-3">
                                    <small class="text-danger">{{ $errors->first('passout_year') }} {{ $errors->first('passout_month') }}</small>
                                </div>
                            </div>

                            {{-- ID Proof --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof (PDF)</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="id_proof" accept="application/pdf" class="form-control">
                                    <small class="text-danger">{{ $errors->first('id_proof') }}</small>
                                </div>
                            </div>

                            {{-- Photo --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Photo</label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="image" accept="image/*" class="form-control">
                                    <small class="text-danger">{{ $errors->first('image') }}</small>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-primary">Register Student</button>
                                    <a href="{{ route('diploma.index') }}" class="btn btn-secondary ml-2">Cancel</a>
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
