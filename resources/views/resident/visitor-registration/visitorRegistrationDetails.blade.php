@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-visitorRegistration" title="Back to Visitor Registration History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Visitor Entry Registration Details</h1><br>
    <!-- Any error within the page -->
    @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" style="width: 100%">{{$error}}</div>
            @endforeach
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger" style="width: 100%">{{session('error')}}</div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success" style="width: 100%">{{session('success')}}</div>
    @endif

    <table class="table table-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Applied Date</th>
            <td>{{ $registration->applied_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Visitor Name</th>
            <td>{{ $registration->visitor_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Purpose</th>
            <td>{{ $registration->visit_purpose }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Visit Date</th>
            <td>{{ $registration->visit_date }}</td>
        </tr>
        <tr>
            @php
                $timeParts = explode(':', $registration->visit_time);
                $hours = (int)$timeParts[0];
                $minutes = $timeParts[1];
                $period = ($hours >= 12) ? 'PM' : 'AM';
                if ($hours > 12) {
                    $hours -= 12;
                } elseif ($hours === 0) {
                    $hours = 12;
                }
                $time12 = $hours . $period;
            @endphp
            <th scope="row" class="table-secondary">Visit Time</th>
            <td>{{ $time12 }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Duration</th>
            <td>{{ $registration->duration }}@if($registration->duration < 60) minutes @else hour @endif</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge @if ($registration->status == 'Approved') bg-success @elseif ($registration->status == 'Pending Approval') bg-warning @else bg-danger @endif text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">QR Code</th>
            <td>@if ($registration->qr_code != null)<img class="" src="{{ asset('images/visitorQR/' . $registration->qr_code) }}" alt="QR Code">@endif</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if ($registration->status == 'Pending Approval')
                <!--Cancel Button-->
                <form action="{{route('resident-visitorRegistration.cancel', ['id'=>$registration->visitor_reg_id])}}" method="post" onsubmit="return confirm('Are you sure to cancel this visitor registration?')">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                </form>
                @endif
            </td>
        </tr>
    </table>
@endsection