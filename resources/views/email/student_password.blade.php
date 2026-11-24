@component('mail::message')
<strong>{{ env('APP_NAME') }}</strong>

Dear {{ $course_students->name }},

Your student account has been created. Below are your login details:

**Password:** {{ $password }}

@if(count($enrollments) > 1)
You have been enrolled in **{{ count($enrollments) }} courses**. Each course has its own Register Number. Use the Register Number of the course you want to access to log in.

@component('mail::table')
| Course Name | Register Number (Login ID) |
|:------------|:--------------------------|
@foreach($enrollments as $e)
| {{ $e['course_name'] }} | {{ $e['register_number'] }} |
@endforeach
@endcomponent

> Use the **Register Number** as your login ID along with the password above.
@else
**Register Number:** {{ $enrollments[0]['register_number'] ?? $course_students->register_number }}

**Course:** {{ $enrollments[0]['course_name'] ?? '' }}
@endif

@component('mail::button', ['url' => config('app.url').'/login'])
Login Now
@endcomponent

Thanks,
{{ env('APP_NAME') }}
@endcomponent
