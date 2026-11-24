@extends('layouts.center.layout')
@section('content')
<div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Change Password</h1>
          </div>
              <div class="row">
              <div class="col-12">
                <div class="card">
    <form method="POST" action="{{route('student.password.change',$student_id)}}" enctype="multipart/form-data">
    {{csrf_field()}}
    {{method_field('POST')}}
    <div class="card-body">

 @if (Session::has('success'))
<div class="alert alert-success">{{Session::get('success')}}</div>
@endif

@if (count($errors)>0)
@foreach ($errors->all() as $error)
<div class="alert alert-danger">
<p>{{$error}}</p>
</div>
@endforeach
@endif   
    <div class="row">
    <div class="col-md-6">
    <div class="form-group">
    <label>PASSWORD</label>
    <input type="password" class="form-control" name="password" required >
    </div>
    </div>
    </div>
    <div class="row">
    <div class="col-md-6">
    <div class="form-group">
    <label>CONFIRM PASSWORD</label>
    <input type="password" class="form-control" name="password_confirmation" required >
    </div>
    </div>
    </div>

    <button type="submit" class="btn btn-info mr-2">Submit</button>
</div>
</form>
</div>
</div>
</div>
</section>
</div>
@endsection