@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Student Submissions</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('admin.assessment.index') }}" class="btn btn-secondary btn-sm">Back to Assessments</a>
  </div></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-light">
            <tr>
              <th>#</th><th>Student</th><th>Assessment</th><th>Trainor</th>
              <th>Submitted At</th><th>Score</th><th>Status</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($submissions as $s)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $s->student->name ?? '-' }}</td>
              <td>{{ $s->assessment->title ?? '-' }}</td>
              <td>{{ $s->assessment->trainor->name ?? '-' }}</td>
              <td>{{ $s->submitted_at ? $s->submitted_at->format('d M Y H:i') : '-' }}</td>
              <td>
                @if(!is_null($s->score))
                  {{ $s->score }} / {{ $s->total_marks }}
                @else
                  -
                @endif
              </td>
              <td>
                @php $badges = ['submitted'=>'warning','evaluated'=>'success']; @endphp
                <span class="badge badge-{{ $badges[$s->status] ?? 'secondary' }}">
                  {{ ucfirst($s->status) }}
                </span>
              </td>
              <td>
                <a href="{{ route('admin.assessment.submission', $s->id) }}" class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i> View
                </a>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">No submissions yet.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div></section>
@endsection
