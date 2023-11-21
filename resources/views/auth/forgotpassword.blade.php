@extends('layouts/master_home')

@section('content')
    <style>
        .forgotpassword-content {
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
            height: 700px;
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
        .alert {
            width: 80%;
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
        .section2-content input[type=text],  .section2-content input[type=password] {
            box-sizing: border-box;
            border: 2px solid #CDD7DF;
            outline: none;
        }
        .section2-content input[type=text]:focus,  .section2-content input[type=password]:focus {
            border: 2px solid #293952;
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
        @media (max-width: 700px) {
            .section1 {
                display: none;
            }
            .secton2, .section2-content input, .password, .alert {
                width: 100%;
            }
        }
    </style>
    <!-- Page content -->
    <table class="forgotpassword-content">
        <tr>
            <td class="section1">
                <img src="{{ asset('images/study.jpg') }}" alt="study">
            </td>
            <td class="section2">
                <div class="section2-content">
                    <h1>Forgot Password</h1>
                    <div class="mt-5">
                        @if($errors->any())
                            <div class="col-12">
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-danger">{{$error}}</div>
                                @endforeach
                            </div>
                        @endif

                        @if(session()->has('error'))
                            <div class="alert alert-danger">{{session('error')}}</div>
                        @endif

                        @if(session()->has('success'))
                            <div class="alert alert-success">{{session('success')}}</div>
                        @endif
                    </div>
                    <form action="{{route('forgotpassword.post')}}" method="POST">
                    @csrf
                        <label for="email">Enter your account email</label><br>
                        <input type="text" id="email" name="email" placeholder="xxx@xx.com" required><br><br>

                        <input type="submit" value="Email Password Reset Link"><br><br>
                    </form>
                </div>
            </td>
        </tr>
    </table>
@endsection