@extends('layouts/master_admin')

@section('content')
    <h1>Hostel Registrations <a class="btn btn-primary" href="admin-semesters" title="Manage Semesters" style="font-size: 1vmax; float: right;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Manage Application Semesters</a></h1><br>

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
    <form class="search" action="{{route('admin-registrationRecord.search')}}" method="GET">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search..." required>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>

    <!-- Check whether have registration record -->
    @if ($registrations->isEmpty())
        <p class="alert alert-danger">No registration record found.</p>
    @endif

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Registration Date</th>
                <th scope="col">Student Name</th>
                <th scope="col">Registration Type</th>
                <th scope="col">Semester</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $registration->registration_date }}</td>
                    <td>{{ $registration->name }}</td>
                    <td>{{ $registration->registration_type }}</td>
                    <td>{{ $registration->semester_name }}</td>
                    <td>{{ $registration->status }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('admin-registrationDetails', ['id'=>$registration->registration_id])}}" title="View Registration" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{$registrations->links()}}
    </div>
@endsection