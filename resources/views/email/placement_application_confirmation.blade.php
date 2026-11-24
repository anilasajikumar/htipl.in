@component('mail::message')
# Hello {{ $application->name }},

Thank you for applying for the **{{ $application->placement->post_name }}** position.

We have received your application and our team will review it.  
You provided the following details:

**Experience:** {{ $application->experience }}  
**Qualification:** {{ $application->qualification }}

**Resume:**  
[Download Resume]({{ asset('uploads/resume/'.$application->resume) }})

We will contact you shortly if you are shortlisted.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
