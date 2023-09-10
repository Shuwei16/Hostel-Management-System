@extends('layouts/master_admin')

@section('content')
    <style>
        .floor-plan {
            background-color: #F2F2F2;
            border-radius: 7px;
            margin: auto;
        }
        .floor-plan td {
            padding: 20px;
            text-align: center;
        }
        .floor-plan .room {
            width: 100px;
            height: 100px;
        }
        .room-side .room {
            width: 20px;
            height: 20px;
        }
        .room-side {
            padding-top: 20px;
            width: 15%;
            left: 0;
            float: left;
        }
        .room-sidebar {
            background-color: #F2F2F2;
            width: 100%;
            text-align: center;
            padding-top: 20px;
        }
        .block {
            font-size: 1.5vmax;
        }
        .room-sidebar ul {
            font-size: 26px;
            list-style-type: none;
            padding: 0;
            margin: 20px 0;
            text-align: center;
        }
        .room-sidebar ul li {
            padding: 20px 10px 20px 10px;
            cursor: pointer;
        }
        .room-sidebar ul li:hover {
            background-color: #334766;
            color: white;
        }
        .room-sidebar .active {
            background-color: #293952;
            color: white;
        }
        .room-details {
            height: 50%;
            width: 25%;
            background-color: #F2F2F2;
            position: fixed;
            top: 25%;
            left: 70%;
            z-index: 1;
            padding: 10px;
            border-radius: 7px;
        }
        .close {
            background-color: white;
            border: none;
        }
    </style>
    <h1>Rooms</h1>
    <div class="room-side">
        <div class="room-sidebar">
            <form id="roomForm" method="POST" action="{{ route('admin-roomManagement.post') }}">
                @csrf
                <input type="hidden" class="form-control" name="floor" id="floor" placeholder="floor" value='G'>
                <select class="btn btn-secondary dropdown-toggle block" id="block" name="block">
                    @foreach($blocks as $block)
                        <option value="{{ $block->block_id }}" {{ $selected_block == $block->block_id ? 'selected' : '' }}>Block {{ $block->block_name }}</option>
                    @endforeach
                </select>
                <ul>
                    <li @if ($selected_floor == "G") class="active" @endif data-value="G">G</li>
                    <li @if ($selected_floor == "1") class="active" @endif data-value="1">F1</li>
                    <li @if ($selected_floor == "2") class="active" @endif data-value="2">F2</li>
                    <li @if ($selected_floor == "3") class="active" @endif data-value="3">F3</li>
                    <li @if ($selected_floor == "4") class="active" @endif data-value="4">F4</li>
                </ul>
            </form>
        </div>
        <br>
        <button type="button" class="btn btn-success room"></button> Empty <br>
        <button type="button" class="btn btn-warning room"></button> Left 1 slot <br>
        <button type="button" class="btn btn-danger room"></button> Full <br>
    </div>
    <table id="floor-plan" class="floor-plan">
        <thead>
            <tr>
                <td colspan="2">
                    <h3>{{ $gender->gender }}'s Rooms</h3>
                </td>
            </tr>
        </thead>
        <tbody>
            @for($i = 0; $i < count($rooms); $i = $i+2)
                <tr>
                    <td><button type="button" class="btn 
                    @if ($rooms[$i]->occupied_slots == 0) btn-success
                    @elseif ($rooms[$i]->occupied_slots == 1) btn-warning
                    @else btn-danger
                    @endif room"
                    onclick="window.location.href = '{{route('admin-roomDetails', ['id'=>$rooms[$i]->room_id])}}';">{{ $rooms[$i]->room_code }}</button></td>

                    <td><button type="button" class="btn 
                    @if ($rooms[$i+1]->occupied_slots == 0) btn-success
                    @elseif ($rooms[$i+1]->occupied_slots == 1) btn-warning
                    @else btn-danger
                    @endif room"
                    onclick="window.location.href = '{{route('admin-roomDetails', ['id'=>$rooms[$i+1]->room_id])}}';">{{ $rooms[$i+1]->room_code }}</button></td>
                </tr>
            @endfor
        </tbody>
    </table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        document.getElementById('block').addEventListener('change', function() {
            document.getElementById('roomForm').submit();
        });
        $(document).ready(function() {
            $('#roomForm li').on('click', function() {
                var selectedValue = $(this).data('value');
                $('#floor').val(selectedValue);
                document.getElementById('roomForm').submit();
            });
        });
    </script>
@endsection