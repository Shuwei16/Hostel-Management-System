@extends('layouts/master_home')

@section('content')
    <style>
        .section1 {
            width: 100%;
            margin: auto;
        }
        .section1 td {
            padding: 20px;
        }
        .desc {
            width: 40%;
        }
        .pic {
            width: 60%;
        }
        .section1 div {
            margin: 20px;
            padding: 0;
            width: 90%;
            height: 300px;
        }
        .desc div {
            background-color: #CDD7DF;
            padding: 5%;
            border-radius: 20px;
        }
        .section1 button {
            font-family: verdana, sans-serif;
            background-color: #F9C03D;
            color: white;
            border: none;
            border-radius: 7px;
            width: 150px;
            padding: 10px 10px;
            transition: 0.5s;
        }
        .section1 button:hover {
            background-color: #facf6b;
        }
        .section1 img{
            width: 100%;
        }
        .section2 h1 {
            text-align: center;
            font-family: verdana, sans-serif;
            color: #FB9D58;
        }
        .section2 table {
            width: 100%;
            background-color: #CDD7DF;
            height: 300px;
        }
    </style>
    <!-- Page content -->
    <table class="section1">
        <tr>
            <td class="desc">
                <div>
                    <p>...</p>
                    <button type="button" onclick="window.location.href = 'signup';">Register Now</button>
                </div>
            </td>
            <td class="pic">
                <img src="{{ asset('images/hostel.jpg') }}" alt="Hostel">
            </td>
        </tr>
    </table>
    <div class="section2">
        <h1 style="text-align: center;">What's New</h1>
        <table>
            <tr>
                <td>
                    
                </td>
                <td>
                    
                </td>
                <td>
                    
                </td>
            </tr>
        </table>
    </div>
@endsection