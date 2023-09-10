@extends('layouts/master_resident')

@section('content')
    <h1>Profile</h1><br>
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
            <th scope="row" class="table-secondary" style="width: 25%">Name</th>
            <td>{{ $profileInfo->name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">IC / Passport</th>
            <td>{{ $profileInfo->ic }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Student ID</th>
            <td>{{ $profileInfo->student_card_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td>{{ $profileInfo->resident_id }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Contact No.</th>
            <td>{{ $contact_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Email</th>
            <td>{{ $profileInfo->email }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Gender</th>
            <td>{{ $profileInfo->gender }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Citizenship</th>
            <td>{{ $profileInfo->citizenship }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Race</th>
            <td>{{ $profileInfo->race }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Home Address</th>
            <td>
                @foreach ($address as $item)
                {{ $item }}@if (!$loop->last),@elseif($loop->last).@endif
                @endforeach
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Emergency Contact Name</th>
            <td>{{ $profileInfo->emergency_contact_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Emergency Contact No.</th>
            <td>{{ $emergency_contact_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Room</th>
            <td>{{ $profileInfo->room_code }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                <!--Edit Button-->
                <button type="button" class="btn btn-primary btn-sm btn-action" onclick="window.location.href = 'resident-editProfile'"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</button>
            </td>
        </tr>
    </table>
@endsection