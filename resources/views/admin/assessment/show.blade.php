@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Assessment: {{ $assessment->title }}</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('admin.assessment.index') }}" class="btn btn-secondary btn-sm">Back</a>
  </div></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h5 class="card-title">Details</h5></div>
        <div class="card-body">
          <table class="table table-sm">
            <tr><th>Trainor</th><td>{{ $assessment->trainor->name ?? '-' }}</td></tr>
            <tr><th>Status</th><td>
              @if($assessment->is_published)
                <span class="badge badge-success">Published</span>
              @else
                <span class="badge badge-secondary">Draft</span>
              @endif
            </td></tr>
            <tr><th>Total Marks</th><td>{{ $assessment->questions->sum('marks') }}</td></tr>
            <tr><th>Questions</th><td>{{ $assessment->questions->count() }}</td></tr>
            <tr><th>Description</th><td>{{ $assessment->description ?? '-' }}</td></tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><h5 class="card-title">Questions</h5></div>
        <div class="card-body">
          @forelse($assessment->questions as $q)
          <div class="mb-3 p-3 border rounded">
            <strong>Q{{ $loop->iteration }}.</strong> {{ $q->question_text }}
            <span class="badge badge-primary float-right">{{ $q->marks }} mark(s)</span>
            @if($q->question_type === 'mcq')
            <ul class="mt-2 mb-0">
              @if($q->option_a)<li class="{{ $q->correct_answer=='A' ? 'text-success font-weight-bold' : '' }}">A. {{ $q->option_a }}</li>@endif
              @if($q->option_b)<li class="{{ $q->correct_answer=='B' ? 'text-success font-weight-bold' : '' }}">B. {{ $q->option_b }}</li>@endif
              @if($q->option_c)<li class="{{ $q->correct_answer=='C' ? 'text-success font-weight-bold' : '' }}">C. {{ $q->option_c }}</li>@endif
              @if($q->option_d)<li class="{{ $q->correct_answer=='D' ? 'text-success font-weight-bold' : '' }}">D. {{ $q->option_d }}</li>@endif
            </ul>
            @else
            <p class="text-muted mt-1 mb-0"><em>Open-ended answer</em></p>
            @endif
          </div>
          @empty
          <p class="text-muted">No questions added to this assessment.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div></section>
@endsection
