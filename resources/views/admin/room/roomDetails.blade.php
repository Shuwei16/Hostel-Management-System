@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-roomManagement" title="Back to Rooms"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Room Details</h1>

    <!-- Any message within the page -->
    @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
                <div class="alert alert-danger" style="width: 100%">{{$error}}</div>
            @endforeach
        </div>
    @endif

    @if(session()->has('error'))
        <div class="alert alert-danger" style="width: 100%">{{session('error')}}</div>
    @endif

    @if(session()->has('success'))
        <div class="alert alert-success" style="width: 100%">{{session('success')}}</div>
    @endif

    <table class="table table-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Room</th>
            <td>{{ $room->room_code }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Block</th>
            <td>{{ $block->block_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Floor</th>
            <td>{{ $room->floor }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                @if($room->occupied_slots == 0)
                    <div class="badge bg-success text-wrap" style="width: 6rem;">Empty</div>
                @elseif($room->occupied_slots == 1)
                    <div class="badge bg-warning text-wrap" style="width: 6rem;">Left 1 stot</div>
                @else
                    <div class="badge bg-danger text-wrap" style="width: 6rem;">Full</div>
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Occupied Slots</th>
            <td>{{ $room->occupied_slots }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Gender</th>
            <td>{{ $block->gender }}</td>
        </tr>
    </table>
    <table class="table table-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%"></th>
            <th scope="row" class="table-secondary" style="width: 37.5%">Resident 1</th>
            <th scope="row" class="table-secondary" style="width: 37.5%">Resident 2</th>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Name</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->name }}
                @else
                none
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->name }}
                @else
                none
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                @if (isset($residents[0]))
                    @if($residents[0]->status == "Pending Payment")
                        <div class="badge bg-warning text-wrap" style="width: 6rem;">{{ $residents[0]->status }}</div>
                    @else
                        <div class="badge bg-success text-wrap" style="width: 6rem;">{{ $residents[0]->status }}</div>
                    @endif
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                    @if($residents[1]->status == "Pending Payment")
                        <div class="badge bg-warning text-wrap" style="width: 6rem;">{{ $residents[1]->status }}</div>
                    @else
                        <div class="badge bg-success text-wrap" style="width: 6rem;">{{ $residents[1]->status }}</div>
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">IC/Passport</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->ic }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->ic }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Resident ID</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->resident_id }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->resident_id }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Student ID</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->student_card_no }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->student_card_no }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Programme Name</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->programme }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->programme }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Year of Study</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->current_year }} / {{ $residents[0]->total_year }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->current_year }} / {{ $residents[1]->total_year }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Semester of Study</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->study_semester }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->study_semester }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Contact No.</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->contact_no }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->contact_no }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Email</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->email }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->email }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Race</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->race }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->race }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Citizenship</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->citizenship }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->citizenship }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Home Address</th>
            <td>
                @if (isset($residents[0]))
                {{ str_replace('|', ', ', $residents[0]->address) }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ str_replace('|', ', ', $residents[1]->address) }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Emergency Contact Name</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->emergency_name }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->emergency_name }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Emergency Contact No.</th>
            <td>
                @if (isset($residents[0]))
                {{ $residents[0]->emergency_contact }}
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                {{ $residents[1]->emergency_contact }}
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if (isset($residents[0]))
                    @if($residents[0]->status == "Payment Completed")
                        <!--Check In Button-->
                        <form action="{{ route('admin-roomCheckIn', ['room_id' => $room->room_id, 'user_id' => $residents[0]->user_id, 'registration_id' => $residents[0]->registration_id]) }}" method="post" onsubmit="return confirm('Are you sure to check in the room for this resident?')">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success btn-sm btn-action">Check In</button>
                        </form>
                    @elseif($residents[0]->status == "Checked In")
                        <!--Check Out Button-->
                        <form action="{{ route('admin-roomCheckOut', ['room_id' => $room->room_id, 'user_id' => $residents[0]->user_id, 'registration_id' => $residents[0]->registration_id]) }}" method="post" onsubmit="return confirm('Are you sure to check out the room for this resident?')">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger btn-sm btn-action">Check Out</button>
                        </form>
                    @endif
                @endif
            </td>
            <td>
                @if (isset($residents[1]))
                    @if($residents[1]->status == "Payment Completed")
                        <!--Check In Button-->
                        <form action="{{ route('admin-roomCheckIn', ['room_id' => $room->room_id, 'user_id' => $residents[1]->user_id, 'registration_id' => $residents[1]->registration_id]) }}" method="post" onsubmit="return confirm('Are you sure to check in the room for this resident?')">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-success btn-sm btn-action">Check In</button>
                        </form>
                    @elseif($residents[1]->status == "Checked In")
                        <!--Check Out Button-->
                        <form action="{{ route('admin-roomCheckOut', ['room_id' => $room->room_id, 'user_id' => $residents[1]->user_id, 'registration_id' => $residents[1]->registration_id]) }}" method="post" onsubmit="return confirm('Are you sure to check out the room for this resident?')">
                            @csrf
                            @method('put')
                            <button type="submit" class="btn btn-danger btn-sm btn-action">Check Out</button>
                        </form>
                    @endif
                @endif
            </td>
        </tr>
    </table>
@endsection