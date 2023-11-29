@extends('layouts/master_admin')

@section('content')
    <h1>Vehicle Parking Pass Applications <a class="btn btn-primary" href="admin-verifyVehicle" title="Verify Vehicle" style="font-size: 1vmax; float: right;"><i class="fa fa-car" aria-hidden="true"></i> Verify Vehicle</a></h1><br>
    <!-- Any message within the page -->
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

    <!-- Search bar -->
    <form class="search" action="{{route('admin-vehicleParkingPassApps.search')}}" method="GET">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search..." required>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>

    <!-- Check whether have any vehicle parking pass application-->
    @if ($applications->isEmpty())
        <p class="alert alert-danger">No vehicle parking pass application record found. </p>
    @endif

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Car</th>
                <th scope="col">Plate No.</th>
                <th scope="col">Color</th>
                <th scope="col">Resident Name</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($applications as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->make }} {{ $item->model }} {{ $item->year }}</td>
                    <td>{{ $item->plate_no }}</td>
                    <td>{{ $item->color }}</td>
                    <td>{{ $item->resident_name }}</td>
                    <td>{{ $item->status }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('admin-vehicleParkingPassDetails', ['id'=>$item->parking_application_id])}}" title="View Parking Application Details" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{$applications->links()}}
    </div>
@endsection