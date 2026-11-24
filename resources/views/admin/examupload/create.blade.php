@extends('layouts.admin.layout')

@section('content')
<div class="main-content">

  <section class="section">
    <div class="section-header">
      <h1>Create Exam</h1>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">

          <form method="POST"
                action="{{ route('examupload.store') }}"
                enctype="multipart/form-data">
            @csrf

            <div class="card-header">
              <h4>Exam Details</h4>
            </div>

            <div class="card-body">

              {{-- Exam Title --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Exam Title <span class="text-danger">*</span>
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="text"
                         name="title"
                         value="{{ old('title') }}"
                         required
                         class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}">
                  <small class="text-danger">{{ $errors->first('title') }}</small>
                </div>
              </div>

              {{-- Description --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Description
                </label>
                <div class="col-sm-12 col-md-7">
                  <textarea name="description"
                            id="description"
                            class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                  <small class="text-danger">{{ $errors->first('description') }}</small>
                </div>
              </div>

              {{-- Exam File Upload --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">
                  Exam File
                </label>
                <div class="col-sm-12 col-md-7">
                  <input type="file"
                         name="file"
                         accept=".pdf,.doc,.docx"
                         class="form-control {{ $errors->has('file') ? 'is-invalid' : '' }}">
                  <small class="text-muted">
                    Allowed formats: PDF, DOC, DOCX
                  </small>
                  <small class="text-danger">{{ $errors->first('file') }}</small>
                </div>
              </div>

              {{-- Submit --}}
              <div class="form-group row mb-4">
                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                <div class="col-sm-12 col-md-7">
                  <button class="btn btn-primary">
                    Create Exam
                  </button>
                  <a href="{{ url('admin/exams') }}" class="btn btn-secondary ml-2">
                    Cancel
                  </a>
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
<script src="https://cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
<script>
  CKEDITOR.config.autoParagraph = false;
  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
  CKEDITOR.config.shiftEnterMode = CKEDITOR.ENTER_BR;
  CKEDITOR.replace('description');
</script>
@endsection
