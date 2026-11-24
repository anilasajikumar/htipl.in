@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Courses Media</h1>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">

                    <form method="POST"
                          action="{{ route('course-media.store') }}"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h4>Create Course Media</h4>
                        </div>

                        <div class="card-body">

                            {{-- Course --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Course</label>
                                <div class="col-md-7">
                                    <select class="form-control" id="course_id" required>
                                        <option value="">----Select----</option>
                                        @foreach($courses as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Course Module --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Course Module</label>
                                <div class="col-md-7">
                                    <select class="form-control"
                                            name="course_module_id"
                                            id="course_module_id"
                                            required>
                                        <option value="">----Select----</option>
                                        @foreach($courseModules as $key => $value)
                                            <option value="{{ $value }}">{{ $key }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            {{-- Description --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Description</label>
                                <div class="col-md-7">
                                    <textarea class="form-control"
                                              name="course_media_description"
                                              rows="4"
                                              required></textarea>
                                </div>
                            </div>

                            {{-- Title --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Title</label>
                                <div class="col-md-7">
                                    <input type="text"
                                           class="form-control"
                                           name="title"
                                           required>
                                </div>
                            </div>

                            {{-- File --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Upload File</label>
                                <div class="col-md-7">
                                    <input type="file"
                                           class="form-control"
                                           name="file"
                                           accept="application/pdf,video/mp4">
                                    <small class="text-muted">
                                        Optional – PDF or MP4
                                    </small>
                                </div>
                            </div>

                            {{-- Video Link --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">Video Link</label>
                                <div class="col-md-7">
                                    <input type="url"
                                           class="form-control"
                                           name="link"
                                           placeholder="YouTube / Vimeo URL">
                                </div>
                            </div>

                            {{-- PDF Link --}}
                            <div class="form-group row mb-4">
                                <label class="col-md-3 col-form-label text-md-right">PDF Link</label>
                                <div class="col-md-7">
                                    <input type="url"
                                           class="form-control"
                                           name="pdf_link"
                                           placeholder="External PDF URL">
                                </div>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">
                                Submit
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
