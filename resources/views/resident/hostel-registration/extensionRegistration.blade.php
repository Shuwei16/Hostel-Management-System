@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-registrationHistory" title="Back to Registration History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Room Stay Extension Registration</h1><br>
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

    @if ($semester === null)
        <p class="alert alert-danger">Room stay extension application is not available yet. Please wait for the next new semester.</p>
    <!-- Extension registration available -->
    @elseif ($registration == null || $registration->status == "Canceled" || $registration->status == "Failed" || $registration->status == "Payment Failed")
        <form class="input-form" action="{{route('resident-extensionRegistration.post')}}" method="post" onsubmit="return confirm('Are you sure to submit this extension registration?')">
            @csrf
            <input type="hidden" class="form-control" name="semester_id" id="semester_id" placeholder="semester_id" value="{{ $semester->semester_id }}">
            <input type="hidden" class="form-control" name="student_id" id="student_id" placeholder="student_id" value="{{ $student->student_id }}">
            <input type="hidden" class="form-control" name="room_id" id="room_id" placeholder="room_id" value="{{ $student->room_id }}">
            <div class="form-group">
                <label for="semester">Semester</label>
                <input type="text" class="form-control" name="semester" id="semester" placeholder="semester" value="{{ $semester->semester_name }}" disabled><br>
            </div>
            <div class="form-group">
                <label for="duration">Duration</label>
                <table class="col-2">
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="start_date" class="sub-label">Start Date</label>
                                <input type="text" class="form-control" name="start_date" id="start_date" placeholder="start_date" value="{{ $semester->start_date }}" disabled>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="end_date" class="sub-label">End Date</label>
                                <input type="text" class="form-control" name="end_date" id="end_date" placeholder="end_date" value="{{ $semester->end_date }}" disabled>
                            </div>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input type="text" class="form-control" name="price" id="price" placeholder="price" value="RM {{ $semester->price }}" disabled><br>
            </div>
            <div class="form-group">
                <table class="col-2">
                    <tr>
                        <td>
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="name" value="{{ auth()->user()->name }}" disabled>
                        </td>
                        <td>
                            <label for="ic">IC/Passport</label>
                            <input type="text" class="form-control" name="ic" id="ic" placeholder="e.g. 990101-10-1234 or AB1234567" value="{{ $student->ic }}" disabled>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
            <div class="form-group">
                <table class="col-2">
                    <tr>
                        <td>
                            <label for="contact_no">Contact No.</label>
                            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="e.g. 0123456789" pattern="^\d{10,11}$" value="{{ $student->contact_no }}" required>
                        </td>
                        <td>
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{ auth()->user()->email }}" disabled>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
            <div class="form-group">
                <label for="room_code">Room</label>
                <input type="text" class="form-control" name="room_code" id="room_code" placeholder="" value="{{ $student->room_code }}" disabled><br>
            </div>
            <br>
            <div class="btn-submit">
                <button type="submit">Apply</button><br><br>
            </div>
        </form>
    <!-- Registration have been made -->
    @else 
        <p class="alert alert-primary">You have alrealy registered for this semester. Click <a href="{{route('resident-registrationDetails', ['id'=>$registration->registration_id])}}">here</a> to view details.</p>
    @endif

@endsection