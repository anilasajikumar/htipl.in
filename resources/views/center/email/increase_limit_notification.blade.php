@component('mail::message')
<strong>{{env('APP_NAME')}}</strong><br>
<br>
{{ Auth::guard('center')->user()->study_center_name }} . study center Request to increase limit of {{ $course->course_name }} on {{ $course->created_at }}
<br>
<br>
@endcomponent
