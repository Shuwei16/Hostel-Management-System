@extends('layouts/master_resident')
@section('content')
    <style>
        .announcement-details {
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
        .announcement-description .commentList {
            height: 100%;
            overflow: auto;
        }
        .announcement-description .content {
            font-size: 2.5vmin;
        }
        .announcement-description .date {
            font-size: 1.5vmin;
            color: #525252;
        }
        .announcement-description .comment {
            font-size: 2.1vmin;
        }
        .announcement-description .name {
            font-size: 2vmin;
            color: #525252;
        }
    </style>
    <a class="btn btn-secondary" href="{{route('resident-announcement')}}" title="Back to Announcements"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Announcements Details</h1>

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
                    <tr style="height: 50%">
                        <td>
                            <div class="commentList">
                                @if ($comments->isEmpty())
                                    <p class="alert alert-danger">No comment yet.</p>
                                @else
                                    @foreach($comments as $item)
                                    <div class="comment">
                                        <div class="name">{{ $item->name }}</div>
                                        <div class="comment-details">{{ $item->content }}</div>
                                        <div class="date">{{ $item->created_at }}</div>
                                    </div>
                                    </br>
                                    @endforeach
                                @endif
                            </div>
                        </td>
                    </tr>
                    <tr style="height: 10%">
                        <td>
                            <form action="{{route('admin-comment')}}" method="post" onsubmit="confirm('Are you sure to post this comment?');">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="{{auth()->user()->id}}">
                                    <input type="hidden" class="form-control" name="user_role" id="user_role" value="{{auth()->user()->role}}">
                                    <input type="hidden" class="form-control" name="announcement_id" id="announcement_id" value="{{ $announcement->announcement_id }}">
                                    <input type="text" class="form-control" name="comment" id="comment" placeholder="Type your comment..." aria-label="comment" aria-describedby="basic-addon2" required>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection