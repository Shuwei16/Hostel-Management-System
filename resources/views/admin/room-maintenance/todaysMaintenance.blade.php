@extends('layouts/master_admin')

@section('content')
    <h1>Today's Maintenance Tasks <a class="btn btn-primary" href="admin-allMaintenances" title="All Maintenances" style="font-size: 1vmax; float: right;"><i class="fa fa-file-text-o" aria-hidden="true"></i> All Maintenance Bookings</a></h1><br>
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

    <!-- Check whether have any maintenance task for today -->
    @if ($maintenances === null)
        <p class="alert alert-danger">No room maintenance task for today.</p>
    @else
        <table class="table" style="font-size: 1vmax">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Room</th>
                    <th scope="col">Resident Code</th>
                    <th scope="col">Maintenance Type</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($maintenances as $item)
                    @php
                        $timeParts = explode(':', $item->time);
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
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td>{{ $item->date }}</td>
                        <td>{{ $time12 }}</td>
                        <td>{{ $item->room_code }}</td>
                        <td>{{ $item->resident_name }}</td>
                        <td>{{ $item->maintenance_type }}</td>
                        <td>{{ $item->status }}</td>
                        <td><a class="btn btn-info btn-sm" href="{{route('admin-maintenanceDetails', ['id'=>$item->maintenance_booking_id])}}" title="View Maintenances" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection