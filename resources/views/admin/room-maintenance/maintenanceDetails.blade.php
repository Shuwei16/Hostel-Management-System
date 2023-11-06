@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-todaysMaintenance" title="Back to Maintenance Booking History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Maintenance Details</h1><br>
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
            <td>{{ $maintenance->applied_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident Name</th>
            <td>{{ $maintenance->resident_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td>{{ $maintenance->resident_id }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Room</th>
            <td>{{ $maintenance->room_code }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance Date</th>
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
            <th scope="row" class="table-secondary">Maintenance Type</th>
            <td>{{ $maintenance->maintenance_type }}</td>
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
                <!--Mark as Done Button-->
                <form action="{{route('admin-maintenanceDetails.done', ['id'=>$maintenance->maintenance_booking_id])}}" method="post" onsubmit="confirm('Are you sure to mark this maintenance as done?')">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i> Mark As Done</button>
                </form>
                @endif
            </td>
        </tr>
    </table>
@endsection