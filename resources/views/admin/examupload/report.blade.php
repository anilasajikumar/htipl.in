@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Exam Report</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Exam Title</th>
                                <th>Student Name</th>
                                <th>File</th>
                                <th>Submitted At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($submissions as $key => $sub)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $sub->exam_title }}</td>
                                    <td>{{ $sub->student_name }}</td>
                                    <td>
                                        @if($sub->file_path)
                                            <a href="{{ asset($sub->file_path) }}" target="_blank" class="btn btn-sm btn-info">Download</a>
                                        @else
                                            —
                                        @endif
                                    </td>
                                    <td>{{ date('d M Y H:i', strtotime($sub->submitted_at)) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No submissions yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </section>
</div>
@endsection
