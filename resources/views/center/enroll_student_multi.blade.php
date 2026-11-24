@extends('layouts.center.layout')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Register Student</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <form method="POST" action="{{ route('student.register') }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="card-body">

                            {{-- Course Selection --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                                    Select Course(s) <span class="text-danger">*</span>
                                </label>
                                <div class="col-sm-12 col-md-7">
                                    @if($active_courses->isEmpty())
                                        <div class="alert alert-warning">
                                            No active courses available. All courses have expired or reached their student limit.
                                        </div>
                                    @else
                                        <div style="border:1px solid #ced4da; border-radius:4px; padding:12px; max-height:220px; overflow-y:auto;">
                                            @foreach($active_courses as $course)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input course-check" type="checkbox"
                                                    name="course_ids[]"
                                                    value="{{ $course->id }}"
                                                    id="course_{{ $course->id }}">
                                                <label class="form-check-label" for="course_{{ $course->id }}">
                                                    <strong>{{ $course->course_name }}</strong>
                                                    <small class="text-muted ml-2">
                                                        (Remaining slots: {{ $course->limit }} &nbsp;|&nbsp; Valid till: {{ date('d-m-Y', strtotime($course->validity)) }})
                                                    </small>
                                                </label>
                                            </div>
                                            @endforeach
                                        </div>
                                        <small class="text-info">You can select multiple courses. Student will be enrolled in all selected courses.</small>
                                    @endif
                                    <small class="text-danger">{{ $errors->first('course_ids') }}</small>
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
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="gender" value="male" {{ old('gender','male') == 'male' ? 'checked' : '' }}> Male
                                    </label>
                                    <label class="radio-inline mr-3">
                                        <input type="radio" name="gender" value="female" {{ old('gender') == 'female' ? 'checked' : '' }}> Female
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" value="other" {{ old('gender') == 'other' ? 'checked' : '' }}> Others
                                    </label>
                                </div>
                            </div>

                            {{-- Address --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Address <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <textarea required class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address">{{ old('address') }}</textarea>
                                    <small class="text-danger">{{ $errors->first('address') }}</small>
                                </div>
                            </div>

                            {{-- Exam Date --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam Date <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="date" required name="exam_date" class="form-control {{ $errors->has('exam_date') ? 'is-invalid' : '' }}" value="{{ old('exam_date') }}">
                                    <small class="text-danger">{{ $errors->first('exam_date') }}</small>
                                </div>
                            </div>

                            {{-- ID Proof --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">ID Proof (PDF) <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="id_proof" accept="application/pdf" required class="form-control">
                                    <small class="text-danger">{{ $errors->first('id_proof') }}</small>
                                </div>
                            </div>

                            {{-- Photo --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Photo <span class="text-danger">*</span></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="file" name="image" accept="image/*" required class="form-control">
                                    <small class="text-danger">{{ $errors->first('image') }}</small>
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button type="submit" class="btn btn-primary" id="submit-btn">Submit</button>
                                    <a href="{{ route('my_course') }}" class="btn btn-secondary ml-2">Cancel</a>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
document.getElementById('submit-btn').addEventListener('click', function(e) {
    var checked = document.querySelectorAll('.course-check:checked');
    if (checked.length === 0) {
        e.preventDefault();
        alert('Please select at least one course.');
    }
});
</script>
@endsection
