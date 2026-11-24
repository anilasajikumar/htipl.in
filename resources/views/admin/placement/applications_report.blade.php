@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1>Placement Applications</h1>
    </div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">

                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">
                                    <thead class="text-white" style="background-color:#6a93b6;">
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Post Name</th>
                                            <th>Applicant Name</th>
                                            <th>Email</th>
                                            <th>Experience</th>
                                            <th>Qualification</th>
                                            <th>Resume</th>
                                            <th>Applied On</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($applications as $key => $app)
                                        <tr class="text-center">
                                            <td>{{ $key + 1 }}</td>

                                            <td>{{ $app->placement->post_name ?? 'N/A' }}</td>

                                            <td>{{ $app->name }}</td>

                                            <td>{{ $app->email }}</td>

                                            <td>{{ $app->experience }}</td>

                                            <td>{{ $app->qualification }}</td>

                                            <td>
                                                @if($app->resume)
                                                    <a class="btn btn-success btn-sm"
                                                       href="{{ asset('uploads/resume/'.$app->resume) }}"
                                                       download>
                                                       Download
                                                    </a>
                                                @else
                                                    No File
                                                @endif
                                            </td>

                                            <td>{{ $app->created_at->format('d M Y, h:i A') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>

                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- card ends -->

                </div>
            </div>
        </div>
    </div>

</section>
</div>
@endsection
