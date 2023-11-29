@extends('layouts/master_admin')

@section('content')
    <h1>Residents' Attendances <a class="btn btn-primary" href="admin-scanFace" title="Record Entry Status" style="font-size: 1vmax; float: right;"><i class="fa fa-check-square-o" aria-hidden="true"></i> Record Entry Status</a></h1><br>
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

    <!-- Search bar -->
    <form class="search" action="{{route('admin-attendance.search')}}" method="GET">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search..." required>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>
    
    <!-- Check whether have any attendance records -->
    @if ($attendances->isEmpty())
        <p class="alert alert-danger">No attendance records found.</p>
    @endif

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Resident Name</th>
                <th scope="col">Resident ID</th>
                <th scope="col">Attendance Type</th>
                <th scope="col">Attendance Date & Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->resident_name }}</td>
                    <td>{{ $item->resident_id }}</td>
                    <td>{{ $item->attendance_type }}</td>
                    <td>{{ $item->datetime }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{$attendances->links()}}
    </div>
@endsection