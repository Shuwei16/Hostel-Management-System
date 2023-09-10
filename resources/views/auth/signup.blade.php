@extends('layouts/master_home')

@section('title', 'Sign Up')

@section('content')
    <style>
        .signup-content {
            width: 100%;
            margin: 0;
            padding: 0;
        }
        .section1 {
            width: 40%;
            background-color: #555555;
        }
        .section1 img {
            width: 100%;
            opacity: 0.5;
        }
        .secton2 {
            width: 60%;
        }
        .section2-content {
            font-family: verdana, sans-serif;
            padding: 40px;
            line-height: 2;
        }
        .section2-content input {
            font-family: verdana, sans-serif;
            width: 80%;
            border-radius: 7px;
            padding: 10px 10px;
            transition: 0.5s;
        }
        .section2-content input[type=label] {
        }
        .section2-content input[type=text],  .section2-content input[type=password], .section2-content input[type=email] {
            box-sizing: border-box;
            border: 2px solid #CDD7DF;
            outline: none;
        }
        .section2-content input[type=text]:hover,  .section2-content input[type=password]:hover, .section2-content input[type=email]:hover {
            box-shadow: 0 1px 20px #CDD7DF;
        }
        .section2-content input[type=submit] {
            background-color: #F9C03D;          
            color: white;
            border: none;
        }
        .section2-content input[type=submit]:hover {
            background-color: #facf6b;
            cursor: pointer;
        }
        .section2-content span, a {
            font-size: 13px;
        }
        .section2-content a {
            text-decoration: none;
            font-weight: bold;
            color: #076dfa;
        }
        ::placeholder {
            opacity: 0.5;
        }
    </style>
    <!-- Page content -->
    <table class="signup-content">
        <tr>
            <td class="section1">
                <img src="{{ asset('images/study.jpg') }}" alt="study">
            </td>
            <td class="section2">
                <div class="section2-content">
                    <h1>Sign Up</h1>
                    <div class="mt-5">
                        @if($errors->any())
                            <div class="col-12">
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger" style="width: 80%">{{$error}}</div>
                                @endforeach
                            </div>
                        @endif

                        @if(session()->has('error'))
                            <div class="alert alert-danger" style="width: 80%">{{session('error')}}</div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success" style="width: 80%">{{session('success')}}</div>
                        @endif
                    </div>
                    <form action="{{route('signup.post')}}" method="POST">
                        @csrf
                        <label for="name">Name as per IC</label><br>
                        <input type="text" id="name" name="name" placeholder="Lew Ah Meng" required><br><br>

                        <!-- <label for="studentID">Student ID</label><br>
                        <input type="text" id="studentID" name="studentID" placeholder="22WMR00123" required><br><br> -->

                        <label for="email">Email Address</label><br>
                        <input type="email" id="email" name="email" placeholder="xxx@xx.com" required><br>
                        <small id="emailHelp" class="form-text text-muted">You're advised to use a valid student email.</small><br><br>

                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password" placeholder="abc123" required><br><br>

                        <label for="password_confirmation">Confirm Password</label><br>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="abc123" required><br><br>

                        <input type="submit" value="Sign Up"><br><br>

                        <span>Already have an account? <a href="login">Sign In</a></span>
                    </form>
                </div>
            </td>
        </tr>
    </table>
@endsection