@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-profile" title="Back to Profile"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Edit Profile</h1><br>
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

    <form class="input-form" action="{{route('resident-editProfile.post')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="student_card_no">Student ID</label>
            <input type="text" class="form-control" name="student_card_no" id="student_card_no" placeholder="e.g. 22WMR00001" pattern="^\d{2}[A-Z]{3}\d{5}$" value="{{ $profileInfo->student_card_no }}" required><br>
        </div>

        <div class="form-group">
            <label for="contact_no">Personal Contact No.</label>
            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="e.g. 0123456789" pattern="^\d{10,11}$" value="{{ $profileInfo->contact_no }}" required><br>
        </div>

        <div class="form-group">
            <label for="address">Home Address</label><br>
            <label for="address_line_1" class="sub-label">Address Line 1</label>
            <input type="text" class="form-control" name="address_line_1" id="address_line_1" placeholder="e.g. 1, Jalan Abc" value="{{ $address[0] }}" required>
            <label for="address_line_2" class="sub-label">Address Line 2</label>
            <input type="text" class="form-control" name="address_line_2" id="address_line_2" placeholder="e.g. Taman Abc" value="@if(isset($address[1])){{ $address[1] }}@endif" required>
            <table class="col-2">
                <tr>
                    <td>
                        <label for="postcode" class="sub-label">Postcode</label>
                        <input type="text" class="form-control" name="postcode" id="postcode" placeholder="e.g. 81300" value="@if(isset($address[2])){{ $address[2] }}@endif" required>
                    </td>
                    <td>
                        <label for="city" class="sub-label">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="e.g. Skudai" value="@if(isset($address[3])){{ $address[3] }}@endif" required>
                    </td>
                </tr>
            </table>
            <table class="col-2">
                <tr>
                    <td>
                        <label for="state" class="sub-label">State</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="e.g. Johor" value="@if(isset($address[4])){{ $address[4] }}@endif" required>
                    </td>
                    <td>
                        <label for="country" class="sub-label">Country</label>
                        <input type="text" class="form-control" name="country" id="country" placeholder="e.g. Malaysia" value="@if(isset($address[5])){{ $address[5] }}@endif" required>
                    </td>
                </tr>
            </table>
            </br>
        </div>

        <div class="form-group">
            <label for="address">Emergency Contact</label>
            <table class="col-2">
                <tr>
                    <td>
                        <label for="emergency_contact_name" class="sub-label">Name</label>
                        <input type="text" class="form-control" name="emergency_contact_name" id="emergency_contact_name" placeholder="your guardian's name" value="{{ $profileInfo->emergency_contact_name }}" required>
                    </td>
                    <td>
                        <label for="emergency_contact_no" class="sub-label">Contact No.</label>
                        <input type="text" class="form-control" name="emergency_contact_no" id="emergency_contact_no" placeholder="e.g. 0123456789" pattern="^\d{10,11}$" value="{{ $profileInfo->emergency_contact }}" required>
                    </td>
                </tr>
            </table>
            <br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Edit</button><br><br>
        </div>
    </form>
@endsection