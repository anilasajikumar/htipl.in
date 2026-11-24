@extends('layouts.center.layout')
@section('style')
<link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endsection
@section('content')
<div class="main-content">

        <section class="section">
          <div class="section-header">
            <h1>Center Exam</h1>
          </div>

              <div class="row">
              <div class="col-12">
                <div class="card">
                <form method="POST" action="{{route('study-center-exam.store')}}" enctype="multipart/form-data">
                    {{csrf_field()}}

                  <div class="card-header">
                    <h4>Create Center Exam</h4>
                  </div>

                  <div class="card-body">

                   

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Exam</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" id="exam" name="exam" required>
                          <option value="">----Select----</option>
                          @foreach($exams as $key => $value)
                          <option value="{{$value}}">{{$key}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Center</label>
                      <div class="col-sm-12 col-md-7">
                        <select class="form-control selectric" id="center" name="center" required>
                          <option value="In Study Center" selected>In Study Center</option>
                          <option value="Outside Center">Outside Study Center</option>
                        </select>
                      </div>
                    </div>


                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Center Address</label>
                      <div class="col-sm-12 col-md-7">
                        <textarea class="form-control" name="address" id="address" rows="100" readonly>{!! Auth::guard('center')->user()->study_center_address !!}</textarea>
                      </div>
                    </div>

                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">Date (Date Should Be After <span id="about_date"></span> Days From Today)</label>
                      <div class="col-sm-12 col-md-7">
                        <input type="text" id="datepicker" name="date" class="form-control">
                      </div>
                    </div>

                   
                    <div class="form-group row mb-4">
                      <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                      <div class="col-sm-12 col-md-7">
                        <button class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </div>
              </form>
                </div>
              </div>
            </div>

        </section>

      </div>
@endsection

@section('script')
<script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

<script type="text/javascript">
$('#center').change(function(event) {
	var value = $('#center').val();
	if (value == 'In Study Center') {
		$('#address').attr("readonly","readonly");
	}
	else
	{
		$('#address').removeAttr("readonly","readonly");
	}
});

$('#exam').change(function(event) {
	var exam = $('#exam').val();
	$.ajax({
            url: '/study-center/exam-date/'+exam,
            type: 'GET',
            dataType: 'html',
        })
        .done(function(data) {
            $('#about_date').text();
            $('#about_date').text(data);


Date.prototype.addDays = function(days) {
    this.setDate(this.getDate() + parseInt(days));
    return this;
};

var today, datepicker;
    today = new Date();
    numberOfDaysToAdd = $('#about_date').text();
    today.addDays(numberOfDaysToAdd);

    
    datepicker = $('#datepicker').datepicker({
            format: 'dd-mm-yyyy',
            minDate: today
        });
        });
});
</script>
@endsection