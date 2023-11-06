@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-maintenance" title="Back to Maintenance Booking History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Maintenance Booking Details</h1><br>
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
            <th scope="row" class="table-secondary" style="width: 25%">Maintenance Date</th>
            <td>{{ $maintenance->date }}</td>
        </tr>
        <tr>
            @php
                $timeParts = explode(':', $maintenance->time);
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
            <th scope="row" class="table-secondary">Maintenance Time Slot</th>
            <td>{{ $time12 }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance type</th>
            <td>{{ $maintenance->maintenance_type }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Applied Date</th>
            <td>{{ $maintenance->applied_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Description</th>
            <td>{{ $maintenance->description }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge text-wrap @if ($maintenance->status == 'Applied') bg-success @elseif ($maintenance->status == 'Canceled') bg-danger @else bg-primary @endif" 
                style="width: 6rem;">{{ $maintenance->status }}</div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if ($maintenance->status == 'Applied')
                <!--Cancel Button-->
                <form action="{{route('resident-maintenanceDetails.cancel', ['id'=>$maintenance->maintenance_booking_id])}}" method="post" onsubmit="confirm('Are you sure to canceled this maintenance booking?')">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                </form>
                @endif
            </td>
        </tr>
    </table>
@endsection