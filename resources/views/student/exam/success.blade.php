@extends('layouts.student.layout')
@section('content')
<div class="main-content">
<section class="section">
<div class="section-header">
<h1>Result</h1>
</div>
<div class="app-content content">
  <div class="content-wrapper">
  <div class="row">
  <div class="col-md-12 grid-margin stretch-card">
  <div class="card">
  <div class="card-body">
<p><span>Total Questions :</span><span> {{ $exam_marks->correct_answers +
 $exam_marks->incorrect_answers + $exam_marks->unanswered }}</span></p>
<p><span>Correct Answers :</span><span> {{ $exam_marks->correct_answers }}</span></p>
<p><span>Wrong Answers :</span><span> {{ $exam_marks->incorrect_answers }}</span></p>
<p><span>UnAnswered :</span><span> {{ $exam_marks->unanswered }}</span></p>
<p><span>Mark Scored :</span><span> {{ $exam_marks->mark_scored }} @if($published_result->result == 'pass')<span class="badge badge-success">Pass</span>@else<span class="badge badge-danger">Failed</span>@endif</span></p>
</section>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
