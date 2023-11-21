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
    <a class="btn btn-secondary" href="resident-changePassword" title="Back to Change Password"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
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

    <form class="input-form" action="{{route('resident-forgotPassword.post')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="email">Enter your account email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="xxx@xx.com" required>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit" style="width: 50%">Email Password Reset Link</button><br><br>
        </div>
    </form>
@endsection