@extends('layouts.student.layout')

@section('content')
<div class="main-content">
<section class="section">

<div class="section-header">
    <h1>Attend Exams</h1>
</div>

<div class="row">
<div class="col-12">
<div class="card">

<div class="card-header">
    <h4>Available Exams</h4>
</div>

<div class="card-body">
<div class="table-responsive">

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-striped">
<thead>
<tr>
    <th>#</th>
    <th>Title</th>
    <th>Question</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>
@forelse($exams as $key => $exam)
<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $exam->title }}</td>

    <td>
        @if($exam->file_path)
            <a href="{{ asset($exam->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                Download
            </a>
        @else
            —
        @endif
    </td>

    <td>
        @if(in_array($exam->id, $submitted))
            <span class="badge badge-success">Submitted</span>
        @else
            <span class="badge badge-warning">Pending</span>
        @endif
    </td>

    <td>
        @if(!in_array($exam->id, $submitted))
       <form action="{{ route('examsattendsubmit', $exam->id) }}"
      method="POST"
      enctype="multipart/form-data">
    @csrf

    <input type="file"
           name="answer_file"
           required
           accept=".pdf,.doc,.docx">

    <button class="btn btn-sm btn-primary mt-1">
        Upload
    </button>
</form>
        @else
           <button class="btn btn-sm btn-primary mt-1">
        Completed
    </button>
        @endif
    </td>
</tr>
@empty
<tr>
    <td colspan="5" class="text-center">No exams available</td>
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
