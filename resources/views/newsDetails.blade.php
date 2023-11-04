@extends('layouts/master_home')

@section('content')
    <style>
        .content {
            padding: 20px;
        }
        .announcement-details {
            margin: 20px;
            padding: 20px;
            box-shadow: 10px 10px 20px #CDD7DF;
            height: 100%;
        }
        .announcement-details .poster {
            width: 100%;
            margin: 0px;
        }
        .announcement-details th {
            padding: 0px;
        }
        .announcement-description {
            height: 100%;
        }
        .announcement-description .content {
            padding: 0px;
            font-size: 2.5vmin;
        }
        .announcement-description .date {
            font-size: 1.5vmin;
            color: #525252;
        }
        .announcement-description .name {
            font-size: 2vmin;
            color: #525252;
        }
    </style>
    
    <div class="content">
        <a class="btn btn-secondary" href="{{route('home')}}" title="Back to Home"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>

        <table class="table announcement-details">
            <tr>
                <th scope="row" class="table-secondary" style="width: 50%">
                    <img class="poster" src="{{ asset('images/announcement/' . $announcement->image) }}" alt="Poster">
                </th>
                <td>
                <table class="table announcement-description">
                        <tr style="height: 40%">
                            <td>
                                <h3>{{ $announcement->title }}</h3>
                                <p class="content">{!! nl2br(e($announcement->content)) !!}</p>
                                <div class="date">created at {{ $announcement->created_at }}</div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
@endsection