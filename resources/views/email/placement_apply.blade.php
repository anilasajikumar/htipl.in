@component('mail::message')
# New Placement Application

**Post Name:** {{ $application->placement->post_name }}

**Applicant Name:** {{ $application->name }}  
**Experience:** {{ $application->experience }}  
**Qualification:** {{ $application->qualification }}

**Resume:**  
{{ asset('uploads/resume/'.$application->resume) }}

Thanks,  
{{ config('app.name') }}
@endcomponent
