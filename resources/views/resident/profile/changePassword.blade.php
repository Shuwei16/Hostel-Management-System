@extends('layouts/master_resident')

@section('content')
    <style>
        a {
            text-decoration: none;
            font-weight: bold;
            color: #076dfa;
            font-size: 13px;
        }
    </style>
    <a class="btn btn-secondary" href="resident-profile" title="Back to Profile"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Change Password</h1><br>
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

    <form class="input-form" action="{{route('resident-changePassword.post')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="old_password">Old Password</label>
            <input type="password" class="form-control" name="old_password" id="old_password" placeholder="e.g. abc123" required>
        </div>
        <a href="resident-forgotPassword">Forgot Password?</a><br><br>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="e.g. xyz456" required><br>
        </div>

        <div class="form-group">
            <label for="confirm">Confirm New Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="e.g. xyz456" required><br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Change</button><br><br>
        </div>
    </form>
@endsection