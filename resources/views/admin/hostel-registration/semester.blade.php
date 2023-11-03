@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-registrationRecord" title="Back to Registration Records"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Semesters <a class="btn btn-success" href="admin-addSemester" title="Add New Semester" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></h1><br>
    
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

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Semester</th>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($semesters as $sem)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $sem->semester_name }}</td>
                    <td>{{ $sem->start_date }}</td>
                    <td>{{ $sem->end_date }}</td>
                    <td>RM {{ $sem->price }}</td>
                    @php
                        $currentDate = now();
                        $startDate = \Carbon\Carbon::parse($sem->extension_reg_open_date);
                        $endDate = \Carbon\Carbon::parse($sem->new_reg_close_date);
                    @endphp
                    @if ($currentDate->gte($startDate) && $currentDate->lte($endDate))
                    <td>Registration Opened</td>
                    @else
                    <td>Registration Closed</td>
                    @endif
                    <td>
                        <a class="btn btn-info btn-sm" href="{{route('admin-viewSemester', ['id'=>$sem->semester_id])}}" title="View Semester" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{$semesters->links()}}
    </div>
@endsection