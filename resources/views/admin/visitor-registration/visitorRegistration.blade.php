@extends('layouts/master_admin')

@section('content')
    <h1>Vistor Entry Registrations <a class="btn btn-primary" href="" title="Scan QR code" style="font-size: 1vmax; float: right;"><i class="fa fa-qrcode" aria-hidden="true"></i> Scan QR Code</a></h1><br>
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
                <th scope="col">Visitor Name</th>
                <th scope="col">Visit Date</th>
                <th scope="col">Visit Time</th>
                <th scope="col">Duration</th>
                <th scope="col">Resident Name</th>
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
                    <td>...</td>
                    <td><a class="btn btn-info btn-sm" href="admin-visitorRegistrationDetails" title="View Visitor Registration Details" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endfor
        </tbody>
    </table>
@endsection