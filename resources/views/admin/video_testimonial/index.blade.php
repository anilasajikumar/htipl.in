@extends('layouts.admin.layout')

@section('content')
<div class="main-content">
<section class="section">

  <div class="section-header">
    <h1>Video Testimonials</h1>
  </div>

  <div class="app-content content">
    <div class="content-wrapper">

      <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
          <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
              <h4 class="mb-0">Video Testimonials</h4>
              <a href="{{ route('video-testimonial.create') }}" class="btn btn-success">
                Add Video
              </a>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead class="text-primary">
                    <tr>
                      <th>Title</th>
                      <th>Description</th>
                      <th>Video</th>
                      <th>Status</th>
                      <th>Delete</th>
                    </tr>
                  </thead>

                  <tbody>
                    @forelse($videos as $video)
                      <tr>
                        <td>{{ $video->title }}</td>
                        <td>{{ Str::limit($video->description, 50) }}</td>
                        <td>
                          <a href="{{ $video->video_link }}" target="_blank" class="btn btn-sm btn-info">
                            View Video
                          </a>
                        </td>
                        <td>
                          @if($video->status)
                            <span class="badge badge-success">Active</span>
                          @else
                            <span class="badge badge-secondary">Inactive</span>
                          @endif
                        </td>
                        <td>
                          <form method="POST" action="{{ route('video-testimonial.delete',$video->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"
                              onclick="return confirm('Do you want to delete this video?')">
                              Delete
                            </button>
                          </form>
                        </td>
                      </tr>
                    @empty
                      <tr>
                        <td colspan="5" class="text-center">No video testimonials found</td>
                      </tr>
                    @endforelse
                  </tbody>

                </table>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

</section>
</div>
@endsection
