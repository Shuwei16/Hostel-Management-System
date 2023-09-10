@extends('layouts/master_home')

@section('title', 'Sign In')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .login-content {
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
            outline: none;
        }
        #email {
            box-sizing: border-box;
            border: 2px solid #CDD7DF;
        }
        .password input {
            border: none;
        }
        .password {
            font-family: verdana, sans-serif;
            width: 80%;
            border-radius: 7px;
            transition: 0.5s;
            box-sizing: border-box;
            border: 2px solid #CDD7DF;
        }
        .password i {
            float: right;
            cursor: pointer;
            margin: 20px 20px;
            color: #666666;
        }
        #hide {
            display: none;
        }
        .section2-content input[type=email]:hover,  .password:hover {
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
    <table class="login-content">
        <tr>
            <td class="section1">
                <img src="{{ asset('images/study.jpg') }}" alt="study">
            </td>
            <td class="section2">
                <div class="section2-content">
                    <h1>Sign In</h1>
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
                    <form action="{{route('login.post')}}" method="POST">
                        @csrf
                        <label for="email">Email</label><br>
                        <input type="email" id="email" name="email" placeholder="xxx@xx.com" required><br><br>

                        <label for="password">Password</label><br>
                        <div class="password">
                            <input type="password" id="password" name="password" placeholder="abc123" required>
                            <i class="fa fa-eye-slash" aria-hidden="true" id="hide" onclick="pswFunction()"></i>
                            <i class="fa fa-eye" aria-hidden="true" id="show" onclick="pswFunction()"></i>
                        </div>
                        
                        <a href="forgotpassword">Forgot Password?</a><br><br><br>

                        <input type="submit" value="Sign In"><br><br>

                        <span>Don't have an account? <a href="signup">Sign Up</a></span>
                    </form>
                </div>
            </td>
        </tr>
    </table>

    <script type="text/javascript">
        function pswFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
                document.getElementById("hide").style.display = "inline-block";
                document.getElementById("show").style.display = "none";
            } else {
                x.type = "password";
                document.getElementById("hide").style.display = "none";
                document.getElementById("show").style.display = "inline-block";
            }
        }
    </script>
@endsection