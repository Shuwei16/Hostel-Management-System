@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-registrationRecord" title="Back to Registration Record"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Registration Details</h1>
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

    <table class="table table-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Student Name</th>
            <td>{{ $registration->name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Student ID</th>
            <td>{{ $registration->student_card_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Email</th>
            <td>{{ $registration->email }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Contact Number</th>
            <td>{{ $registration->contact_no }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Semester</th>
            <td>{{ $registration->semester_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Registration Date</th>
            <td>{{ $registration->registration_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Registration Type</th>
            <td>{{ $registration->registration_type }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Assigned Room</th>
            <td>{{ $registration->room_code }}</td>
        </tr>
        @if($registration->payment_date !== null)
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Payment Date</th>
            <td>{{ $registration->payment_date }}</td>
        </tr>
        @endif
        @if($registration->check_in_date !== null)
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Check In Date</th>
            <td>{{ $registration->check_in_date }}</td>
        </tr>
        @endif
        @if($registration->check_out_date !== null)
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Check Out Date</th>
            <td>{{ $registration->check_out_date }}</td>
        </tr>
        @endif
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                @if($registration->status == "Pending Payment")
                    <div class="badge bg-warning text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @elseif($registration->status == "Failed" || $registration->status == "Canceled")
                    <div class="badge bg-danger text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @else
                    <div class="badge bg-success text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @endif
            </td>
        </tr>
    </table>

@endsection