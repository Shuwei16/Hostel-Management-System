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
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident Name</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Make</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Model</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Year</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Color</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Plate No.</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge bg-warning text-wrap" style="width: 6rem;">Pending Approval</div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                <!--Approve Button-->
                <button type="button" class="btn btn-success btn-sm btn-submit" onclick="window.location.href = ''"><i class="fa fa-check" aria-hidden="true"></i> Approve</button>
                <!--Reject Button-->
                <button type="button" class="btn btn-danger btn-sm btn-submit" onclick="window.location.href = ''"><i class="fa fa-times" aria-hidden="true"></i> Reject</button>
            </td>
        </tr>
    </table>
@endsection