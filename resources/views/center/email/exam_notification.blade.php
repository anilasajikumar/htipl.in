@component('mail::message')
<strong>{{env('APP_NAME')}}</strong><br>
<br>
{{ Auth::guard('center')->user()->study_center_name }} . study center created a new exam {{ $exam->exam_name }} on {{ $exam->created_at }}
<br>
<br>
@endcomponent
