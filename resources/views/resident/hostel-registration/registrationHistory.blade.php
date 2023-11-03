@extends('layouts/master_resident')

@section('content')
    <h1>Registration History <a class="btn btn-primary" href="resident-extensionRegistration" title="Extension Registration" style="font-size: 1vmax; float: right;"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Apply Room Stay Extension</a></h1><br>
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
                <th scope="col">Duration of Stay</th>
                <th scope="col">Price</th>
                <th scope="col">Registration Date</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->semester_name }}</td>
                    <td>{{ $item->start_date }} - {{ $item->end_date }}</td>
                    <td>RM {{ $item->price }}</td>
                    <td>{{ $item->registration_date }}</td>
                    <td>{{ $item->status }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('resident-registrationDetails', ['id'=>$item->registration_id])}}" title="View Registration" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection