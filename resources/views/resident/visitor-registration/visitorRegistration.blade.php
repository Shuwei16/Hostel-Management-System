@extends('layouts/master_resident')

@section('content')
    <h1>Vistor Entry Registration History <a class="btn btn-success" href="resident-addVisitorRegistration" title="Add Visitor Registration" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></h1><br>
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

    <!-- Check whether have any visitor registration-->
    @if ($registrations->isEmpty())
        <p class="alert alert-danger">No visitor entry registration yet. Click <a href="resident-addVisitorRegistration">here</a> to register for a visitor.</p>
    @else
        <table class="table" style="font-size: 1vmax">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Visitor Name</th>
                    <th scope="col">Visit Date</th>
                    <th scope="col">Visit Time</th>
                    <th scope="col">Duration</th>
                    <th scope="col">Applied Date</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $item)
                    @php
                        $timeParts = explode(':', $item->visit_time);
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
                    <td>{{ $item->visitor_name }}</td>
                    <td>{{ $item->visit_date }}</td>
                    <td>{{ $time12 }}</td>
                    <td>{{ $item->duration }}@if($item->duration < 60) minutes @else hour @endif</td>
                    <td>{{ $item->applied_date }}</td>
                    <td>{{ $item->status }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('resident-visitorRegistrationDetails', ['id'=>$item->visitor_reg_id])}}" title="View Visitor Registration Details" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{$registrations->links()}}
        </div>
    @endif
@endsection