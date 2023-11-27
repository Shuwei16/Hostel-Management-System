@extends('layouts/master_resident')
@section('content')
<style>
    .table-details {
        width: 100%;
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
    .customer-service-icon {
        background-color: white;
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 5px solid #293952;
        padding: 3px;
    }
    .customer-service-icon img {
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

    <h1>Chat With Hostel Service Team</h1>
    <table class="table-details">
        <tr class="chat-header">
            <td style="width: 10%"><div class="customer-service-icon"><img src="{{ asset('images/customer-service.png') }}" /></div></td>
            <td>Hostel Administrative</td>
        </tr>
        <tr>
            <td colspan="2">
                <div class="chat-messages" id="chat-messages">
                    @if ($messages->isEmpty())
                        <div class="message received">Hello, how can I help you today? <br/><br/>(This is an auto generated message. You can now chat with hostel admin if you are facing any issue, and you will be replied during working hours.)</div>
                    @else 
                        @foreach($messages as $item)
                            <div class="message @if($item->sender_id == auth()->id()) sent @else received @endif">{{$item->message}}</div>
                        @endforeach
                    @endif
                </div>
            </td>
        </tr>
        <tr>
            <td colspan="2" class="chat-input">
                <form action="{{route('resident-chat.post')}}" method="post" style="width: 100%">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="message" id="message" placeholder="Type your message..." required>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
    </table>

<script>
    function scrollToBottom() {
        var chatContainer = document.getElementById('chat-messages');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    window.onload = function() {
        scrollToBottom();
    };
</script>

@endsection