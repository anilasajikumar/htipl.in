@extends('layouts.web.layout')
@section('content')

<section class="about_icrq">
    <div class="container">

        <div class="row">
            <div class="col-md-7">
                <h2>Apply for {{ $placement->post_name }}</h2>
            </div>
        </div>

        <div class="col-md-12 mt-5">

            <div class="row">
                <div class="col-md-6">

                    <form action="{{ route('placement.apply.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="placement_id" value="{{ $placement->id }}">

                        <h4 class="mb-5">Complete the Application Form</h4>

                        <div class="form-group">
                            <label>Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Experience <span class="text-danger">*</span></label>
                            <input type="text" name="experience" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Qualification <span class="text-danger">*</span></label>
                            <input type="text" name="qualification" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Resume (PDF / DOC / JPG) <span class="text-danger">*</span></label>
                            <input type="file" name="resume" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Submit Application</button>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
