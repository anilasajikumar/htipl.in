@extends('layouts.admin.layout')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Student Registration</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('student.registerupdate', $student->id) }}" enctype="multipart/form-data">
                        {{csrf_field()}}
    {{method_field('POST')}}
                       
                        <div class="card-body">
                            
<!--<div class="form-group row mb-4">-->
<!--    <label class="col-form-label col-md-3">Type <span class="text-danger">*</span></label>-->
<!--    <div class="col-md-7">-->
<!--        <select name="course_type" class="form-control" required>-->
<!--            <option value="">-- Select Type --</option>-->
<!--            <option value="Diploma" {{ old('course_type', $student->course_type) == 'Diploma' ? 'selected' : '' }}>Diploma</option>-->
<!--            <option value="Certificate" {{ old('course_type', $student->course_type) == 'Certificate' ? 'selected' : '' }}>Certificate</option>-->
<!--        </select>-->
<!--    </div>-->
<!--</div>-->
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Course Name <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                   <select name="course_id" class="form-control" required>
    <option value="">-- Select Course --</option>
    @foreach($courses as $course)
        <option value="{{ $course->id }}" {{ $course->id == $student->center_online_courses_id ? 'selected' : '' }}>
            {{ $course->course_name }}
        </option>
    @endforeach
</select>

                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Student Name <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}" required>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Email <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $student->email) }}" required>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Mobile <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="text" name="mobile" class="form-control" value="{{ old('mobile', $student->mobile) }}" required>
                                </div>
                            </div>

                               {{-- Father Name --}}
                        <div class="form-group row mb-4">
                            <label class="col-form-label col-md-3">Father Name <span class="text-danger">*</span></label>
                            <div class="col-md-7">
                                <input type="text" name="father_name" class="form-control" value="{{ old('father_name', $student->father_name) }}" required>
                            </div>
                        </div>
                        
                        {{-- Passout Year and Month --}}
                       <div class="form-group row mb-4">
        <label class="col-form-label col-md-3">Passout Year and Month <span class="text-danger">*</span></label>
        <div class="col-sm-12 col-md-7 d-flex gap-2">
            @php
                $passoutYear = \Carbon\Carbon::parse($student->passout_year_month)->format('Y');
                $passoutMonth = \Carbon\Carbon::parse($student->passout_year_month)->format('m');
            @endphp
            <select name="passout_year" class="form-control" required>
                <option value="">Select Year</option>
                @for ($year = 1980; $year <= now()->year + 5; $year++)
                    <option value="{{ $year }}" {{ $passoutYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                @endfor
            </select>

            <select name="passout_month" class="form-control" required>
                <option value="">Select Month</option>
                @for ($m = 1; $m <= 12; $m++)
                    @php $monthVal = str_pad($m, 2, '0', STR_PAD_LEFT); @endphp
                    <option value="{{ $monthVal }}" {{ $passoutMonth == $monthVal ? 'selected' : '' }}>
                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                    </option>
                @endfor
            </select>
        </div>
    </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">DOB <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <input type="date" name="dob" class="form-control"
    value="{{ old('dob', \Carbon\Carbon::parse($student->dob)->format('Y-m-d')) }}" required>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Gender <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <label><input type="radio" name="gender" value="male" {{ $student->gender == 'male' ? 'checked' : '' }}> Male</label>
                                    <label><input type="radio" name="gender" value="female" {{ $student->gender == 'female' ? 'checked' : '' }}> Female</label>
                                    <label><input type="radio" name="gender" value="other" {{ $student->gender == 'other' ? 'checked' : '' }}> Other</label>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Address <span class="text-danger">*</span></label>
                                <div class="col-md-7">
                                    <textarea name="address" class="form-control" required>{{ old('address', $student->address) }}</textarea>
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">ID Proof (PDF)</label>
                                <div class="col-md-7">
                                    <input type="file" name="id_proof" class="form-control" accept="application/pdf">
                                    @if($student->id_proof)
                                        <a href="{{ asset('storage/'.$student->id_proof) }}" target="_blank">View existing</a>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <label class="col-form-label col-md-3">Image</label>
                                <div class="col-md-7">
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    @if($student->image)
                                        <img src="{{ asset('storage/'.$student->image) }}" height="80">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row mb-4">
                                <div class="col-md-7 offset-md-3">
                                    <button type="submit" class="btn btn-info">Update</button>
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
