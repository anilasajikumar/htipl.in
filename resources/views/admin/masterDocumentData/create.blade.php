@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Create Master Document</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="{{ route('masterdocumentdata.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="form-group">
        <label>Title <span class="text-danger">*</span></label>
        <input type="text" name="title" value="{{ old('title') }}" required class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('title') }}</small>
      </div>
      <div class="form-group">
        <label>Category <span class="text-danger">*</span></label>
        <select name="category" required class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}">
          <option value="">-- Select Category --</option>
          <option value="my_document" {{ old('category') == 'my_document' ? 'selected' : '' }}>My Document</option>
          <option value="my_download" {{ old('category') == 'my_download' ? 'selected' : '' }}>My Download</option>
          <option value="exam_assignments" {{ old('category') == 'exam_assignments' ? 'selected' : '' }}>Exam & Assignments</option>
          <option value="feedback" {{ old('category') == 'feedback' ? 'selected' : '' }}>Feedback</option>
        </select>
        <small class="text-danger">{{ $errors->first('category') }}</small>
      </div>
      <div class="form-group">
        <label>Online Course</label>
        <select name="course_id" class="form-control">
          <option value="">-- All Courses --</option>
          @foreach($course as $name => $id)
            <option value="{{ $id }}" {{ old('course_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Options</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="text" value="1" {{ old('text') ? 'checked' : '' }}>
          <label class="form-check-label">Text Entry</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="file" value="1" {{ old('file') ? 'checked' : '' }}>
          <label class="form-check-label">File Upload</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="student_upload" value="1" {{ old('student_upload') ? 'checked' : '' }}>
          <label class="form-check-label">Student Upload</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="download" value="1" {{ old('download') ? 'checked' : '' }}>
          <label class="form-check-label">Download</label>
        </div>
      </div>
      <div class="form-group">
        <label>Default File</label>
        <input type="file" name="default_file" class="form-control-file">
        <small class="text-muted">Accepted: PDF, JPG, PNG, DOC, DOCX (max 2MB)</small>
        <small class="text-danger">{{ $errors->first('default_file') }}</small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="student_download_default_file" value="1" {{ old('student_download_default_file') ? 'checked' : '' }}>
          <label class="form-check-label">Allow Student to Download Default File</label>
        </div>
      </div>
      <button class="btn btn-primary">Submit</button>
      <a href="{{ route('masterdocumentdata.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection
