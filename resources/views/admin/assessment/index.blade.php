@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Assessments</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('admin.assessment.submissions') }}" class="btn btn-info btn-sm">
      <i class="fas fa-list"></i> View Submissions
    </a>
  </div></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
  <div class="card">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-light">
            <tr>
              <th>#</th><th>Title</th><th>Trainor</th><th>Questions</th>
              <th>Submissions</th><th>Status</th><th>Created</th><th>Action</th>
            </tr>
          </thead>
          <tbody>
            @forelse($assessments as $a)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $a->title }}</td>
              <td>{{ $a->trainor->name ?? '-' }}</td>
              <td>{{ $a->questions_count }}</td>
              <td>{{ $a->student_assessments_count }}</td>
              <td>
                @if($a->is_published)
                  <span class="badge badge-success">Published</span>
                @else
                  <span class="badge badge-secondary">Draft</span>
                @endif
              </td>
              <td>{{ $a->created_at->format('d M Y') }}</td>
              <td>
                <a href="{{ route('admin.assessment.show', $a->id) }}" class="btn btn-info btn-sm">
                  <i class="fas fa-eye"></i> View
                </a>
              </td>
            </tr>
            @empty
            <tr><td colspan="8" class="text-center text-muted">No assessments found.</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div></section>
@endsection
