@extends('layouts/master_resident')

@section('content')
    <h1>Maintenance Booking History <a class="btn btn-success" href="{{route('resident-addMaintenance')}}" title="Add Maintenaces" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Apply New Maintenance</a></h1><br>
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

    <!-- Check whether have maintenance record -->
    @if ($maintenances === null)
        <p class="alert alert-danger">No room maintenance booking yet. Click <a href="resident-addMaintenance">here</a> to apply new room maintenance booking.</p>
    @else
        <table class="table" style="font-size: 1vmax">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Maintenance Type</th>
                    <th scope="col">Applied Date</th>
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
                        <td>{{ $item->maintenance_type }}</td>
                        <td>{{ $item->applied_date }}</td>
                        <td>{{ $item->status }}</td>
                        <td><a class="btn btn-info btn-sm" href="{{route('resident-maintenanceDetails', ['id'=>$item->maintenance_booking_id])}}" title="View Maintenances" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{$maintenances->links()}}
        </div>
    @endif
@endsection