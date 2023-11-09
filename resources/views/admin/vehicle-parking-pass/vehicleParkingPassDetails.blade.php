@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-vehicleParkingPassApps" title="Back to Parking Application History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Vehicle Parking Pass Application Details</h1><br>
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
            <td>{{ $application->applied_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident Name</th>
            <td>{{ $application->resident_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td>{{ $application->resident_id }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Make</th>
            <td>{{ $application->make }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Model</th>
            <td>{{ $application->model }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Year</th>
            <td>{{ $application->year }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Color</th>
            <td>{{ $application->color }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Plate No.</th>
            <td>{{ $application->plate_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge text-wrap @if ($application->status == 'Approved') bg-success @elseif ($application->status == 'Pending Approval') bg-warning @else bg-danger @endif" 
                style="width: 6rem;">{{ $application->status }}</div>
                @if ($application->note != null) <span style="font-size: 12px">Reject notes: {{ $application->note }}</span> @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
            @if($application->status == 'Pending Approval')
                <!--Approve Button-->
                <form action="{{route('admin-vehicleParkingPass.approve', ['id'=>$application->parking_application_id])}}" method="post" onsubmit="return confirm('Are you sure to approve this vehicle parking pass?')">
                    @csrf
                    <button type="submit" id="btn-approve" class="btn btn-success btn-sm btn-action"><i class="fa fa-check" aria-hidden="true"></i> Approve</button>
                </form>
                <!--Reject Button-->
                <form action="{{route('admin-vehicleParkingPass.reject', ['id'=>$application->parking_application_id])}}" method="post" onsubmit="return confirm('Are you sure to reject this vehicle parking pass?')">
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