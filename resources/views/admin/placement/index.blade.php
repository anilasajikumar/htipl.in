@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">

    <div class="section-header">
        <h1>Placement Opportunities</h1>
    </div>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">

                    <div class="card">

                        <!-- Add Button -->
                        <div class="text-left p-3">
                            <a href="{{ route('placements.create') }}">
                                <button class="btn btn-success">+ Add New</button>
                            </a>
                        </div>

                        <!-- Table -->
                        <div class="card-body">
                            <div class="table-responsive">

                                <table class="table table-bordered table-striped">
                                    <thead class="text-primary">
                                        <tr>
                                            <th>Post Name</th>
                                            <th>Experience</th>
                                            <th>Company</th>
                                            <th>Salary</th>
                                            <th>Qualification</th>
                                            <th width="140px">Actions</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($placements as $place)
                                            <tr>
                                                <td>{{ $place->post_name }}</td>
                                                <td>{{ $place->experience }}</td>
                                                <td>{{ $place->company }}</td>
                                                <td>{{ $place->salary }}</td>
                                                <td>{{ $place->qualification }}</td>

                                                <td>
                                                    <a href="{{ route('placements.edit', $place->id) }}"
                                                       class="btn btn-warning btn-sm">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('placements.destroy', $place->id) }}"
                                                          method="POST"
                                                          style="display:inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button onclick="return confirm('Are you sure?')"
                                                                class="btn btn-danger btn-sm">
                                                            Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                    <!-- card end -->

                </div>
            </div>
        </div>
    </div>

</section>
</div>
@endsection
