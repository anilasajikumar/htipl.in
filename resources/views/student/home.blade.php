@extends('layouts.student.layout')

@section('content')

{{-- My Enrollments (visible only when enrolled in 2+ courses) --}}
@if($all_enrollments->count() > 1)
<div class="main-content">
<section class="section">
  <div class="section-header">
    <h1>MY ENROLLED COURSES</h1>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <p class="text-muted">You are enrolled in multiple courses. Each course has a separate Register Number. To access a different course, log out and log in with that course's Register Number.</p>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead class="text-primary">
                <tr>
                  <th>#</th>
                  <th>Course Name</th>
                  <th>Register Number</th>
                  <th>Currently Active</th>
                </tr>
              </thead>
              <tbody>
                @foreach($all_enrollments as $i => $enroll)
                <tr @if($enroll->id == Auth::guard('student')->user()->id) style="background:#f0fff4;" @endif>
                  <td>{{ $i + 1 }}</td>
                  <td>{{ $enroll->course_name }}</td>
                  <td><strong>{{ $enroll->register_number }}</strong></td>
                  <td>
                    @if($enroll->id == Auth::guard('student')->user()->id)
                      <span class="badge badge-success">Current Session</span>
                    @else
                      <span class="badge badge-secondary">Login with this Reg. No. to access</span>
                    @endif
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
@endif
<div class="main-content">
<section class="section">
  <div class="section-header">
    <h1>MY COURSE MODULES</h1>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <div class="table-responsive">

            <table class="table table-bordered table-striped">
              <thead class="text-primary">
                <tr>
                  <th>COURSE MODULE</th>
                  <th>DESCRIPTION</th>
                  <th>VIDEO</th>
                  <th>ATTACHMENTS</th>
                </tr>
              </thead>

              <tbody>
                @forelse($my_courses as $course)
                <tr>
                  <td>{{ $course->course_module_name }}</td>

                  <td>
                    {{ Str::limit(strip_tags($course->course_module_description), 120) }}
                  </td>

                  <td>
                    <a href="{{ route('medias.video', $course->course_module_name) }}"
                       class="btn btn-primary btn-sm">
                      View Videos
                    </a>
                  </td>

                  <td>
                    <a href="{{ route('medias.file', $course->course_module_name) }}"
                       class="btn btn-secondary btn-sm">
                      View PDF
                    </a>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center text-danger">
                    No course modules found
                  </td>
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
