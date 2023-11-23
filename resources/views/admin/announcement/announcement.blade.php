@extends('layouts/master_admin')

@section('content')
    <h1>Announcements <a class="btn btn-success" href="admin-addAnnouncement" title="Add Announcement" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></h1><br>

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
    <form class="search" action="{{route('admin-announcement.search')}}" method="GET">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" name="search" placeholder="Search..." required>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
            </div>
        </div>
    </form>

    <!-- Check whether have announcement record -->
    @if ($announcements->isEmpty())
        <p class="alert alert-danger">No announcement found.</p>
    @endif

    <table class="table" style="font-size: 1vmax">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Title</th>
                <th scope="col">Posted Date</th>
                <th scope="col">Announced Block</th>
                <th scope="col">Announced Gender</th>
                <th scope="col">Publicity</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($announcements as $item)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->created_at }}</td>
                    <td>{{ $item->announced_block }}</td>
                    <td>{{ $item->announced_gender }}</td>
                    <td>{{ $item->publicity }}</td>
                    <td><a class="btn btn-info btn-sm" href="{{route('admin-announcementDetails', ['id'=>$item->announcement_id])}}" title="View Announcement" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{$announcements->links()}}
    </div>
@endsection