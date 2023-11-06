@extends('layouts/master_resident')

@section('content')
    <style>
        .time-slot-grid {
            background-color: #F2F2F2;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-gap: 30px;
            padding: 20px;
        }
        .time-slot {
            border-radius: 7px;
            text-align: center;
            height: 100px;
        }
        .time-slot button {
            width: 100%;
            height: 100%;
        }
        .time-slot-small {
            width: 20px;
            height: 20px;
        }
        @media only screen and (max-width: 800px) {
            .time-slot-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }
    </style>

    <a class="btn btn-secondary" href="resident-maintenance" title="Back to Maintenance History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Maintenance Booking</h1><br>
    <!-- Any error within the page -->
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

    <form class="input-form" id="inputForm" action="{{ route('resident-addMaintenance.action') }}" method="post" onsubmit="confirm('Are you sure to book this appointment for room maintenance?');">
        @csrf
        <div class="form-group">
            Dear residents, if there is any maintenance to be done in your room, you are required to make an appointment on the time and date one week before. All maintanances only available on weekdays only.
            </br></br>
        </div>
        <div class="form-group">
            <label for="date">Date</label>
            <select name="date" name="date" class="form-control" id="date" required>
                @foreach ($dates as $date)
                <option value="{{ $date }}" {{ $selected_date == $date ? 'selected' : '' }}>{{ $date }}</option>
                @endforeach
            </select>
            </br>
        </div>
        <div class="form-group">
            <label for="time">Time Slot</label>
            <div class="time-slot-grid">
                @foreach ($slots as $slot)
                @php
                    $timeParts = explode(':', $slot->time);
                    $hours = (int)$timeParts[0];
                    $minutes = $timeParts[1];
                    $period = ($hours >= 12) ? 'PM' : 'AM';
                    if ($hours > 12) {
                        $hours -= 12;
                    } elseif ($hours === 0) {
                        $hours = 12;
                    }
                    $time12 = $hours . $period;
                @endphp
                    <div class="time-slot">
                        <input type="hidden" id="slot" value="{{ $slot->slot_id }}" />
                        <button type="button" class="btn 
                            @if ($slot->status == 1) btn-success
                            @else btn-danger @endif" @if ($slot->status != 1) disabled @endif>{{ $time12 }}</button>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-success time-slot-small"></button> Available
            <button type="button" class="btn btn-danger time-slot-small" disabled></button> Not Available
            <button type="button" class="btn btn-primary time-slot-small"></button> Selected
            <input type="hidden" id="selected_slot" name="selected_slot" value="" required/>
            </br></br>
        </div>

        <div class="form-group">
            <label for="maintenance_type">Maintenance Type</label>
            <select name="maintenance_type" name="maintenance_type" class="form-control" id="maintenance_type" required>
                <option value="">- select maintenance type -</option>
                <option value="Light Bulb Replacement">Light Bulb Replacement</option>
                <option value="Furniture Repairing">Furniture Repairing</option>
                <option value="Clothesline Maintenance">Clothesline Maintenance</option>
                <option value="Others">Others (State your own maintenance requirement)</option>
            </select>
            </br>
        </div>

        <div class="form-group">
            <label for="description">Description (Describe clearly about your required maintanance item)</label>
            <textarea class="form-control" name="description" id="description" placeholder="" value="" rows="5" cols="50" required></textarea><br>
        </div>

        <br>
        <input type="hidden" id="isSubmit" name="isSubmit" value="false" />
        <div class="btn-submit" id="btn-submit">
            <button type="submit">Book</button><br><br>
        </div>
    </form>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // Confirm whether it is submit the form when calling post method
        document.getElementById('btn-submit').addEventListener('click', function() {
            document.getElementById('inputForm').setAttribute('method', 'post');
            document.getElementById('inputForm').submit();
        });

        // Change the slots selection based on the date selection (submit form to call the post method)
        document.getElementById('date').addEventListener('change', function() {
            document.getElementById('inputForm').setAttribute('method', 'get');
            document.getElementById('inputForm').submit();
        });

        //
        document.addEventListener("DOMContentLoaded", function () {
            const buttons = document.querySelectorAll('.time-slot button.btn');
            const selectedSlot = document.getElementById('selected_slot');

            buttons.forEach(function (button) {
                button.addEventListener('click', function () {
                    if (!button.classList.contains('btn-danger')) {
                        // Reset all buttons to 'btn-success'
                        buttons.forEach(function (otherButton) {
                            otherButton.classList.remove('btn-primary');
                            otherButton.classList.add('btn-success');
                        });

                        // Change the selected button to 'btn-primary'
                        button.classList.remove('btn-success');
                        button.classList.add('btn-primary');

                        // Record the selected slot
                        const slotId = button.parentElement.querySelector('#slot').value;
                        selectedSlot.value = slotId;
                    }
                });
            });
        });
    </script>
@endsection