@component('mail::message')
<strong>{{env('APP_NAME')}}</strong><br>
<br>
CENTER : {{$center->study_center_name}} <br>
Email : {{$center->study_center_email}} <br>
PASSWORD : {{$password}} <br>
<br>
<br>
@endcomponent
