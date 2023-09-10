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
                    <form action="#" method="POST">
                        <label for="idEmail">ID or Email</label><br>
                        <input type="text" id="idEmail" name="idEmail" placeholder="xxx@xx.com" required><br><br>

                        <label for="password">Password</label><br>
                        <input type="password" id="password" name="password" placeholder="abc123" required><br><br>

                        <a href="#">Forgot Password</a><br><br>

                        <input type="submit" value="Sign In"><br><br>

                        <span>Don't have an account? <a href="signup">Sign Up</a></span>
                    </form>
                </div>
            </td>
        </tr>
    </table>
@endsection