@extends('layouts.admin.layout')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Diploma Students</h1>
            <div class="section-header-button">
                <a href="{{ route('diploma.create') }}" class="btn btn-primary">Add New</a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Diploma Student List</h4>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="diploma-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Father Name</th>
                                        <th>Course</th>
                                        <th>Register No.</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Passout</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($students as $i => $s)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $s->student_name }}</td>
                                        <td>{{ $s->father_name }}</td>
                                        <td>{{ $s->course_name }}</td>
                                        <td><strong>{{ $s->register_number }}</strong></td>
                                        <td>{{ $s->email }}</td>
                                        <td>{{ $s->mobile }}</td>
                                        <td>{{ $s->passout_year_month }}</td>
                                        <td>
                                            <form action="{{ route('diploma.destroy', $s->id) }}" method="POST"
                                                onsubmit="return confirm('Delete this student?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">No diploma students found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('script')
<script>
    $('#diploma-table').DataTable({ responsive: true });
</script>
@endsection
