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
            border-radius: 0px;
        }
        .announcement .poster {
            height: 70%;
        }
        .announcement .title {
            font-size: 1.5vmax;
        }
        .announcement .date {
            font-size: 1vmax;
        }
    </style>
    <h1>Announcements</h1>
    <div class="announcement-containter">
        <div class="row">
            @for ($i = 0; $i < 6; $i++)
            <div class="col-md-3 announcement-col">
                <a href="resident-announcementDetails">
                <div class="card announcement" style="">
                    <img class="card-img-top poster" src="{{ asset('images/announcement/poster-1.jpg') }}" alt="Poster">
                    <div class="card-body">
                        <h4 class="card-text title">
                            @php
                                $content = "title 2222 22222 2222222 2222222 22222 222222 22222 222222"
                            @endphp
                            @if(strlen($content) > 45)
                                {{ Str::limit($content, 45, '...') }}
                            @else
                                {{ $content }}
                            @endif
                        </h4>
                        <p class="date">date</p>
                    </div>
                </div>
                </a>
            </div>
            @endfor
        </div>
    </div>
@endsection