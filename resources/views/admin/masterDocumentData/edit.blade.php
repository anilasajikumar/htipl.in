@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Edit Master Document</h1></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card"><div class="card-body">
    <form method="POST" action="{{ route('masterdocumentdata.update', $master_document_data->id) }}" enctype="multipart/form-data">
      @csrf @method('PATCH')
      <div class="form-group">
        <label>Title <span class="text-danger">*</span></label>
        <input type="text" name="title" value="{{ old('title', $master_document_data->title) }}" required class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
        <small class="text-danger">{{ $errors->first('title') }}</small>
      </div>
      <div class="form-group">
        <label>Category <span class="text-danger">*</span></label>
        <select name="category" required class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}">
          <option value="">-- Select Category --</option>
          @foreach(['my_document' => 'My Document', 'my_download' => 'My Download', 'exam_assignments' => 'Exam & Assignments', 'feedback' => 'Feedback'] as $val => $label)
            <option value="{{ $val }}" {{ (old('category', $master_document_data->category) == $val) ? 'selected' : '' }}>{{ $label }}</option>
          @endforeach
        </select>
        <small class="text-danger">{{ $errors->first('category') }}</small>
      </div>
      <div class="form-group">
        <label>Online Course</label>
        <select name="course_id" class="form-control">
          <option value="">-- All Courses --</option>
          @foreach($course as $name => $id)
            <option value="{{ $id }}" {{ (old('course_id', $master_document_data->course_id) == $id) ? 'selected' : '' }}>{{ $name }}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label>Options</label><br>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="text" value="1" {{ (old('text') !== null ? old('text') : $master_document_data->text) ? 'checked' : '' }}>
          <label class="form-check-label">Text Entry</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="file" value="1" {{ (old('file') !== null ? old('file') : $master_document_data->file) ? 'checked' : '' }}>
          <label class="form-check-label">File Upload</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="student_upload" value="1" {{ (old('student_upload') !== null ? old('student_upload') : $master_document_data->student_upload) ? 'checked' : '' }}>
          <label class="form-check-label">Student Upload</label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="checkbox" name="download" value="1" {{ (old('download') !== null ? old('download') : $master_document_data->download) ? 'checked' : '' }}>
          <label class="form-check-label">Download</label>
        </div>
      </div>
      <div class="form-group">
        <label>Default File</label>
        @if($master_document_data->default_file)
          <div class="mb-2">
            <a href="{{ asset('masterDocuments/'.$master_document_data->default_file) }}" target="_blank" class="btn btn-sm btn-info" download>Current File</a>
          </div>
        @endif
        <input type="file" name="default_file" class="form-control-file">
        <small class="text-muted">Leave blank to keep current file.</small>
        <small class="text-danger">{{ $errors->first('default_file') }}</small>
      </div>
      <div class="form-group">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="student_download_default_file" value="1" {{ (old('student_download_default_file') !== null ? old('student_download_default_file') : $master_document_data->student_download_default_file) ? 'checked' : '' }}>
          <label class="form-check-label">Allow Student to Download Default File</label>
        </div>
      </div>
      <button class="btn btn-primary">Update</button>
      <a href="{{ route('masterdocumentdata.index') }}" class="btn btn-secondary ml-2">Cancel</a>
    </form>
  </div></div>
</div></section>
@endsection
