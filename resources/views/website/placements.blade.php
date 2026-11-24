@extends('layouts.web.layout')
<style>
    table thead th {
        font-size: 16px;
        font-weight: 600;
    }
</style>

@section('content')
<div class="container mt-5">

    <h2 class="mb-4">Placement Opportunities</h2>

    <table class="table table-bordered mt-4 mb-5">
        <thead style="background-color: #fd7e14;">
            <tr class="text-white text-center">
                <th scope="col">POST NAME</th>
                <th scope="col">EXPERIENCE</th>
                <th scope="col">COMPANY AND LOCATION</th>
                <th scope="col">SALARY</th>
                <th scope="col">QUALIFICATION</th>
                <th scope="col">LAST DATE TO APPLY</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>

        <tbody>
            @foreach($placements as $data)
            <tr class="text-center">
                <td class="table-secondary">{{ $data->post_name }}</td>
                <td class="table-secondary">{{ $data->experience }}</td>
                <td class="table-secondary">{{ $data->company }}</td>
                <td class="table-secondary">{{ $data->salary }}</td>
                <td class="table-secondary">{{ $data->qualification }}</td>
                <td class="table-secondary">{{ $data->last_date_to_apply }}</td>
                <td class="table-secondary">
                    <a href="{{ route('placement.apply', $data->id) }}" 
                       class="btn btn-primary btn-sm">
                        Apply Now
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
