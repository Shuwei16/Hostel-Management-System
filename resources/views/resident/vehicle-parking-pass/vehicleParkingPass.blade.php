@extends('layouts/master_resident')

@section('content')
    <h1>Vehicle Parking Pass Application History <a class="btn btn-success" href="resident-applyVehicleParkingPass" title="Add Parking Application" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></h1><br>
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

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Car</th>
                <th scope="col">Plate No.</th>
                <th scope="col">Color</th>
                <th scope="col">Applied Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @for ($i = 0; $i < 6; $i++)
                <tr>
                    <th scope="row">{{ $i+1 }}</th>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td>...</td>
                    <td><a class="btn btn-info btn-sm" href="resident-vehicleParkingPassDetails" title="View Parking Application Details" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection