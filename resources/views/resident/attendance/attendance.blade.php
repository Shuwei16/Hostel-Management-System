@extends('layouts/master_resident')

@section('content')
    <h1>Attendances History</h1><br>
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

    <!-- Check whether have any attendance records -->
    @if ($attendances->isEmpty())
        <p class="alert alert-danger">No attendance records yet.</p>
    @else
        <table class="table" style="font-size: 1vmax">
            <thead>
                <tr>
                    <th scope="col">No.</th>
                    <th scope="col">Attendance Type</th>
                    <th scope="col">Attendance Date & Time</th>
                </tr>
            </thead>
            <tbody>
            @foreach($attendances as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->attendance_type }}</td>
                    <td>{{ $item->datetime }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif
@endsection