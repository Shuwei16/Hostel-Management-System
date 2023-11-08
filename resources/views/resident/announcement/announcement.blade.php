@extends('layouts/master_resident')
@section('content')
    <style>
        .announcement-containter {
            background-color: #EFEFEF;
            padding: 3px 15px 3px 15px;
            border-radius: 5px;
            height: 100%;
        }
        .announcement-containter a {
            text-decoration: none;
        }
        .announcement-col {
            padding: 0px;
        }
        .announcement {
            background-color: #FFFFFF;
            height: 500px;
            margin: 5px;
            border: none;
            border-radius: 5px;
        }
        .announcement .poster {
            height: 70%;
        }
        .announcement .title {
            font-size: 3vmin;
        }
        .announcement .date {
            font-size: 2vmin;
        }
    </style>
    <h1>Announcements</h1>

    <!-- Check whether have any announcement -->
    @if ($announcements === null)
        <p class="alert alert-danger">No announcement yet.</p>
    @else
        <div class="announcement-containter">
            <div class="row">
                @foreach ($announcements as $item)
                <div class="col-md-3 announcement-col">
                    <a href="{{route('resident-announcementDetails', ['id'=>$item->announcement_id])}}">
                    <div class="card announcement" style="">
                        <img class="card-img-top poster" src="{{ asset('images/announcement/' . $item->image) }}" alt="Poster">
                        <div class="card-body">
                            <h4 class="card-text title">
                                @php
                                    $title = "$item->title"
                                @endphp
                                @if(strlen($title) > 45)
                                    {{ Str::limit($title, 45, '...') }}
                                @else
                                    {{ $title }}
                                @endif
                            </h4>
                            <p class="date">posted on {{ $item->created_at }}</p>
                        </div>
                    </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    @endif
@endsection