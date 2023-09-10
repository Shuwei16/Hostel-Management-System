@extends('layouts/master_admin')

@section('content')
    <h1>Announcements <a class="btn btn-success" href="admin-addAnnouncement" title="Manage Semesters" style="font-size: 1vmax; float: right;"><i class="fa fa-plus" aria-hidden="true"></i> Add New</a></h1><br>

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
            @for ($i = 0; $i < 6; $i++)
                <tr>
                    <th scope="row">{{ $i+1 }}</th>
                    <td>title here...</td>
                    <td>date</td>
                    <td>All</td>
                    <td>Female</td>
                    <td>Private</td>
                    <td><a class="btn btn-info btn-sm" href="admin-announcementDetails" title="View Registration" style="font-size: 1vmax"><i class="fa fa-eye" aria-hidden="true"></i> View</a></td>
                </tr>
            @endfor
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        
    </div>
@endsection