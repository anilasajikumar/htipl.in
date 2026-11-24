@extends('layouts.web.layout')
@section('content')
<section class="user_register_page">
  <div class="container-fluid">
    <div class="container">


 <div class="jumbotron text-center" style="background-color: #ffffff">
  <h1 class="display-3">Thank You!</h1>
  {{-- <p class="lead"><h2>{{$enquiry->name}}</h2></p> --}}
  <p class="lead">
    <a class="btn btn-primary btn-sm" href="{{ url('/') }}" role="button">Continue to homepage</a>
  </p>
</div>
</div>
</div>
</section>
@endsection
