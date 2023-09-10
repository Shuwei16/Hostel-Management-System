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
    <a class="btn btn-secondary" href="resident-announcement" title="Back to Announcements"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Announcements Details</h1>


    <table class="table announcement-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 50%">
                <img class="poster" src="{{ asset('images/announcement/poster-1.jpg') }}" alt="Poster">
            </th>
            <td>
                <table class="table announcement-description">
                    <tr style="height: 40%">
                        <td>
                            <h3>Title</h3>
                            <p class="content">Content here...</p>
                            <div class="date">Date</div>
                        </td>
                    </tr>
                    <tr style="height: 50%">
                        <td>
                            <div class="commentList">
                                @for ($i = 0; $i < 6; $i++)
                                <div class="comment">
                                    <div class="name">Name</div>
                                    <div class="comment-details">Comment</div>
                                    <div class="date">Date</div>
                                </div>
                                </br>
                                @endfor
                            </div>
                        </td>
                    </tr>
                    <tr style="height: 10%">
                        <td>
                            <form action="" method="post">
                            @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="comment" id="comment" placeholder="Type your comment..." value=""><br>
                            </div>
                        </form>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
@endsection