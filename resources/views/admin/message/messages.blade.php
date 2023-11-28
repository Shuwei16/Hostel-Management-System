@extends('layouts/master_admin')
@section('content')
<style>
    .table-details {
        width: 100%;
    }
    .chat-list-container {
        width: 30%;
        vertical-align: top;
        background-color: #EFEFEF;
    }
    .chat-list-container table {
        width: 100%;
    }
    .message-header td {
        font-weight: bold;
        font-size: 16px;
        padding: 10px;
        border-bottom: 2px solid #CCCCCC;
    }
    .chat-list form{
        padding: 5px;
    }
    .chat-list ul{
        height: 480px;
        overflow: auto;
        vertical-align: text-top;
        font-size: 14px;
        font-weight: normal;
        list-style-type: none;
        padding: 0;
        margin: 20px 0;
        text-align: left;
    }
    .chat-list ul li {
        padding: 15px;
        cursor: pointer;
        transition: 0.5s;
    }
    .chat-list ul li:hover {
        background-color: #dedede;
    }
    .chat-list img {
        background-color: white;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        margin-right: 10px;
        float: left;
    }
    .chat-list span {
        font-size: 10px;
    }
    .chat-header {
        background-color: #F9C03D;
    }
    .chat-header td {
        color: white;
        font-weight: bold;
        font-size: 20px;
        padding: 10px;
    }
    .chat-user-icon {
        background-color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 5px solid #293952;
        padding: 3px;
    }
    .chat-user-icon img {
        width: 100%;
        height: auto;
    }
    .chat-messages {
        padding: 10px;
        height: 500px;
        overflow: auto;
        vertical-align: text-top;
        bottom: 0;
        padding-bottom: 100px;
    }
    .message {
        width: 40%;
        margin: 10px;
        padding: 5px 10px;
        border-radius: 20px;
        word-wrap: break-word;
    }
    .received {
        background-color: #ffe8b3;
        margin-right: auto;
    }
    .sent {
        background-color: #EFEFEF;
        margin-left: auto;
    }
    .chat-input {
        padding: 10px;
        border-top: 1px solid #EFEFEF;
    }

    @media only screen and (max-width: 1000px) {
        .message {
            width: 50%;
        }
    }

    @media only screen and (max-width: 800px) {
        .message {
            width: 60%;
        }
    }
</style>

    <h1>Residents' Messages</h1>
    
    <table class="table-details">
        <tr>
            <th class="chat-list-container" style="width: 30%">
                <table style="font-size: 1vmax">
                    <tr class="message-header">
                        <td>Messages</td>
                    </tr>
                    <tr class="chat-list">
                        <td>
                            <form action="{{route('admin-message.search')}}" method="GET" style="width: 100%">
                                @csrf
                                <input type="text" class="form-control" name="search" id="search" placeholder="Search or start a new chat..." aria-label="comment" aria-describedby="basic-addon2" required>
                            </form>
                            <form id="chatForm" action="{{route('admin-message.select')}}" method="post" style="width: 100%">
                                @csrf
                                <input type="hidden" class="form-control" name="user" id="user" required>
                                <ul>
                                    @if(!$residents->isEmpty())
                                        @foreach($residents as $item)
                                        <li @if($user->user_id == $item->user_id) style="background-color: #CDD7DF;" @endif data-value="{{$item->user_id}}">
                                            @php
                                                $message = '...';
                                                $status = '';
                                                foreach($chats as $chatItem) {
                                                    if(($chatItem->receiver_id == $item->user_id || $chatItem->sender_id == $item->user_id)) {
                                                        $message = $chatItem->message;
                                                        if($chatItem->receiver_id == auth()->id()) {
                                                            $status = $chatItem->status;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            <img src="@if ($item->gender == 'Male') {{ asset('images/male.png') }} @else {{ asset('images/female.png') }} @endif" />
                                            <div>{{$item->room_code}} - {{$item->name}} @if($status == 'sent')<span style="float: right; width: 10px; height: 10px; border-radius: 50%; background-color: red; "></span>@endif<br>
                                                <span>{{ Str::limit($message, 10, '...') }}</span>
                                            </div>
                                        </li>
                                        @endforeach
                                    @else
                                    <div class="alert alert-danger" style="width: 100%">No resident found.</div>
                                    @endif
                                </ul>
                            </form>
                        </td>
                    </tr>
                </table>
            </th>
            <td>
                <table class="table-details">
                    <tr class="chat-header">
                        <td style="width: 10%"><div class="chat-user-icon"><img src="@if($user != '') @if ($user->gender == 'Male') {{ asset('images/male.png') }} @else {{ asset('images/female.png') }} @endif @endif" /></div></td>
                        <td>@if($user != '') {{$user->room_code}} - {{$user->name}} @endif</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div class="chat-messages" id="chat-messages">
                            @if($messages != '')
                                @foreach($messages as $item)
                                    <div class="message @if($item->sender_id == auth()->id()) sent @else received @endif">{!! nl2br(e($item->message)) !!}</div>
                                @endforeach
                                @if($messages->isEmpty())
                                    <div class="alert alert-warning" style="width: 100%">Send a message to start a new chat now.</div>
                                @endif
                            @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="chat-input">
                            <form action="@if($user != '') {{route('admin-message.post')}}  @endif" method="post" style="width: 100%">
                                @csrf
                                <div class="input-group mb-3">
                                    <input type="hidden" class="form-control" name="user_id" id="user_id" value="@if($user != '') {{$user->user_id}} @endif" required>
                                    <textarea class="form-control" name="message" id="message" placeholder="Type your message..." rows="1" required></textarea>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function scrollToBottom() {
            var chatContainer = document.getElementById('chat-messages');
            chatContainer.scrollTop = chatContainer.scrollHeight;
        }
        function adjustMessageWidth() {
            var messages = document.querySelectorAll('.message');
            messages.forEach(function(message) {
                var containerWidth = document.getElementById('chat-messages').offsetWidth;
                var maxWidthPercentage = 70; // Set the maximum width percentage
                var maxWidth = (containerWidth * maxWidthPercentage) / 100;
                
                message.style.maxWidth = maxWidth + 'px';
            });
        }
        window.onload = function() {
            scrollToBottom();
            adjustMessageWidth();
        };
        window.onresize = function() {
            adjustMessageWidth();
        };
        $(document).ready(function() {
            $('#chatForm li').on('click', function() {
                var selectedValue = $(this).data('value');
                $('#user').val(selectedValue);
                console.log(selectedValue);
                document.getElementById('chatForm').submit();
            });
        });
    </script>

@endsection