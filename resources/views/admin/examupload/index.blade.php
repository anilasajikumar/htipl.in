@extends('layouts.admin.layout')

@section('content')
<div class="main-content">

  <section class="section">
    <div class="section-header">
      <h1>Exams</h1>
      <div class="section-header-button">
        <a href="{{ route('examupload.create') }}" class="btn btn-primary">
          Create Exam
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="card">

          <div class="card-header">
            <h4>Exam List</h4>
          </div>

          <div class="card-body">
            <div class="table-responsive">

              <table class="table table-striped" id="table-1">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Created At</th>
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
                          <a href="{{ asset($exam->file_path) }}"
                             class="btn btn-sm btn-info"
                             target="_blank">
                            Download
                          </a>
                        @else
                          <span class="badge badge-secondary">No File</span>
                        @endif
                      </td>

                      <td>{{ date('d M Y', strtotime($exam->created_at)) }}</td>

                      <td>
                        <a href="{{ url('admin/exams/'.$exam->id.'/submissions') }}"
                           class="btn btn-sm btn-primary">
                          Submissions
                        </a>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center">
                        No exams found
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
