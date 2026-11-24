@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1>Add Placement Opportunity</h1>
    </div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-8 offset-md-2 grid-margin stretch-card">

                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('placements.store') }}" method="POST">
                                @csrf

                                <div class="form-group mb-3">
                                    <label>Post Name</label>
                                    <input type="text" name="post_name" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Experience</label>
                                    <input type="text" name="experience" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Company & Location</label>
                                    <input type="text" name="company" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Salary</label>
                                    <input type="text" name="salary" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Qualification</label>
                                    <input type="text" name="qualification" class="form-control" required>
                                </div>
                                
                                   <div class="form-group mb-3">
                                    <label>Last Date to Apply</label>
                                    <input type="date" name="last_date_to_apply" class="form-control" required>
                                </div>

                                <button class="btn btn-success">Submit</button>
                                <a href="{{ route('placements.index') }}" class="btn btn-secondary">Back</a>

                            </form>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
</div>
@endsection
