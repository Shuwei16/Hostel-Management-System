@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-vehicleParkingPass" title="Back to Parking Application History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
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
                @if ($application->plate_no != null) <span style="font-size: 12px">Notes: {{ $application->note }}</span> @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if($application->status != 'Canceled' && $application->status != 'Rejected' && $application->status != 'Expired')
                <!--Update Button-->
                <button type="button" class="btn btn-primary btn-sm btn-action" onclick="window.location.href = '{{route('resident-updateVehicleInfo', ['id'=>$application->parking_application_id])}}'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Update</button>

                <!--Cancel Button-->
                <form action="{{route('resident-vehicleParkingPass.cancel', ['id'=>$application->parking_application_id])}}" method="post" onsubmit="confirm('Are you sure to cancel this vehicle parking pass?')">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                </form>
                @endif
            </td>
        </tr>
    </table>
@endsection