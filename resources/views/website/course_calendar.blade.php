@extends('layouts.web.layout')
@section('content')
<div class="container mt-5">
<h2>Course Calender</h2>
<table class="table table-bordered mt-4 mb-5">
  <thead style="background-color:  #fd7e14;">
    <tr class="text-white text-center">
      <th scope="col">COURSE NAME</th>
      <th scope="col">COURSE STARTING DATE</th>
      <th scope="col">LOCATION</th>
      <th scope="col">EXAM DATE</th>
    </tr>
  </thead>
  <tbody>
    @foreach($calendar as $data)
    <tr class="text-center">
      <td class="table-secondary">{{$data->course_name}}</td>
      <td class="table-secondary">{{ \Carbon\Carbon::parse($data->starting_date)->format('j F Y') }}</td>
      <td class="table-secondary">{{$data->location}}</td>
      <td class="table-secondary">
        {{ \Carbon\Carbon::parse($data->exam_date)->format('j F Y') }} &nbsp; <br>
        <a style="text-decoration: none;" class="btn-sm btn-success mt-1" href="{{ route('apply_now.mail') }}">
          <small>Apply Now</small>
        </a>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
</div>
@endsection