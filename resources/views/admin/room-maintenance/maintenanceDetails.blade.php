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
            <th scope="row" class="table-secondary">Room</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance Date</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance Time Slot</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance Type</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Description</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge bg-success text-wrap" style="width: 6rem;">Applied</div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                <button type="button" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i> Mark As Done</button>
            </td>
        </tr>
    </table>
@endsection