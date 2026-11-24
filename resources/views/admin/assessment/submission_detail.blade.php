@extends('layouts.admin.layout')
@section('content')
<div class="content-header"><div class="container-fluid"><div class="row mb-2">
  <div class="col-sm-6"><h1 class="m-0">Submission Detail</h1></div>
  <div class="col-sm-6"><div class="float-sm-right">
    <a href="{{ route('admin.assessment.submissions') }}" class="btn btn-secondary btn-sm">Back</a>
  </div></div>
</div></div></div>
<section class="content"><div class="container-fluid">
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-header"><h5 class="card-title">Submission Info</h5></div>
        <div class="card-body">
          <table class="table table-sm">
            <tr><th>Student</th><td>{{ $submission->student->name ?? '-' }}</td></tr>
            <tr><th>Assessment</th><td>{{ $submission->assessment->title ?? '-' }}</td></tr>
            <tr><th>Trainor</th><td>{{ $submission->assessment->trainor->name ?? '-' }}</td></tr>
            <tr><th>Submitted</th><td>{{ $submission->submitted_at ? $submission->submitted_at->format('d M Y H:i') : '-' }}</td></tr>
            <tr><th>Score</th><td>{{ $submission->score ?? '-' }} / {{ $submission->total_marks ?? '-' }}</td></tr>
            <tr><th>Status</th><td>
              @php $badges = ['submitted'=>'warning','evaluated'=>'success','pending'=>'secondary']; @endphp
              <span class="badge badge-{{ $badges[$submission->status] ?? 'secondary' }}">
                {{ ucfirst($submission->status) }}
              </span>
            </td></tr>
          </table>
        </div>
      </div>

      @if($submission->evaluation)
      <div class="card">
        <div class="card-header"><h5 class="card-title">Evaluation</h5></div>
        <div class="card-body">
          <table class="table table-sm">
            <tr><th>Evaluated By</th><td>{{ $submission->evaluation->trainor->name ?? '-' }}</td></tr>
            <tr><th>Grade</th><td>{{ $submission->evaluation->grade ?? '-' }}</td></tr>
            <tr><th>Score Override</th><td>{{ $submission->evaluation->score_override ?? '-' }}</td></tr>
            <tr><th>Comments</th><td>{{ $submission->evaluation->comments ?? '-' }}</td></tr>
          </table>
        </div>
      </div>
      @endif
    </div>

    <div class="col-md-8">
      <div class="card">
        <div class="card-header"><h5 class="card-title">Answers</h5></div>
        <div class="card-body">
          @php
            $answersByQuestion = $submission->answers->keyBy('assessment_question_id');
          @endphp
          @forelse($submission->assessment->questions as $q)
          <div class="mb-3 p-3 border rounded">
            <strong>Q{{ $loop->iteration }}.</strong> {{ $q->question_text }}
            <span class="badge badge-primary float-right">{{ $q->marks }} mark(s)</span>
            @php $ans = $answersByQuestion->get($q->id); @endphp
            <div class="mt-2">
              <strong class="text-muted">Student Answer:</strong>
              <span class="{{ $q->question_type==='mcq' && $ans && $ans->answer==$q->correct_answer ? 'text-success' : 'text-danger' }}">
                {{ $ans->answer ?? '<em>No answer</em>' }}
              </span>
              @if($q->question_type === 'mcq')
              &nbsp;&mdash;&nbsp;<strong class="text-success">Correct: {{ $q->correct_answer }}</strong>
              @endif
            </div>
          </div>
          @empty
          <p class="text-muted">No questions found.</p>
          @endforelse
        </div>
      </div>
    </div>
  </div>
</div></section>
@endsection
