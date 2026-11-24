@component('mail::message')
<strong>STUDENT ENQUIRY</strong><br>
<br>
Name : {{$center['name']}} <br>
Email : {{$center['email']}} <br>
Contact Number : {{$center['contact_number']}} <br>
Center : {{$study_center_name}} <br>
Course : {{$course_name}} <br>
Message: {{$center['message']}} <br>
<br>
<br>
@endcomponent
