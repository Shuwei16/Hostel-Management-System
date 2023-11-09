@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-visitorRegistration" title="Back to Visitor Registrations"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
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
            <th scope="row" class="table-secondary">Resident Name</th>
            <td>{{ $registration->resident_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td>{{ $registration->resident_id }}</td>
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
        @if ($registration->check_in_time != null)
        <tr>
            <th scope="row" class="table-secondary">Check-In Time</th>
            <td>{{ $registration->check_in_time }}</td>
        </tr>
        @endif
        @if ($registration->check_out_time != null)
        <tr>
            <th scope="row" class="table-secondary">Check-Out Time</th>
            <td>{{ $registration->check_out_time }}</td>
        </tr>
        @endif
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge @if ($registration->status == 'Approved') bg-success @elseif ($registration->status == 'Pending Approval') bg-warning @else bg-danger @endif text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @if ($registration->note != null) <span style="font-size: 12px">Reject notes: {{ $registration->note }}</span> @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if ($registration->status == 'Pending Approval')
                    <!--Approve Button-->
                    <form action="{{route('admin-visitorRegistration.approve', ['id'=>$registration->visitor_reg_id])}}" method="post" onsubmit="return confirm('Are you sure to approve this visitor registration?')">
                        @csrf
                        <button type="submit" id="btn-approve" class="btn btn-success btn-sm btn-action"><i class="fa fa-check" aria-hidden="true"></i> Approve</button>
                    </form>
                    <!--Reject Button-->
                    <form action="{{route('admin-visitorRegistration.reject', ['id'=>$registration->visitor_reg_id])}}" method="post" onsubmit="return confirm('Are you sure to reject this visitor registration?')">
                        @csrf
                        <button type="button" id="btn-reject" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
                        <input type="hidden" class="form-control" id="note" name="note" placeholder="Write some notes here about why reject..." value="" required/>
                    </form>
                @endif
            </td>
        </tr>
    </table>

    <script>
        const btnApprove = document.getElementById('btn-approve');
        const btnReject = document.getElementById('btn-reject');
        const notesInput = document.getElementById('note');

        btnReject.addEventListener('click', function() {
            notesInput.type = 'text';
        });

        btnApprove.addEventListener('click', function() {
            notesInput.type = 'hidden';
        });
    </script>
@endsection