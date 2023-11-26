@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-visitorRegistration" title="Back to Visitor Registration History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Visitor Entry Registration</h1><br>
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

    <form class="input-form" action="{{ route('resident-addVisitorRegistration.post') }}" method="post" onsubmit="return confirm('Are your sure to register this visior?')">
        @csrf

        <div class="form-group">
            <label for="visitor_name">Visitor Name</label>
            <input type="text" class="form-control" name="visitor_name" id="visitor_name" placeholder="" value="" required><br>
        </div>

        <div class="form-group">
            <label for="visit_purpose">Purpose</label>
            <textarea class="form-control" name="visit_purpose" id="visit_purpose" placeholder="Reason why want to visit..." value="" rows="5" cols="50" requried></textarea><br>
        </div>

        <div class="form-group">
            <table class="col-2">
                <tr>
                    <td>
                        <label for="visit_date">Visit Date</label>
                        <input type="datetime-local" class="form-control" name="visit_date" id="visit_date" placeholder="- select date -" value="" required>
                    </td>
                    <td>
                        <label for="visit_time">Visit Time</label>
                        <select name="visit_time" name="visit_time" class="form-control" id="visit_time" required>
                            <option value="" selected disabled>- select time -</option>
                            <option value="9:00:00">9AM</option>
                            <option value="10:00:00">10AM</option>
                            <option value="11:00:00">11AM</option>
                            <option value="12:00:00">12PM</option>
                            <option value="13:00:00">1PM</option>
                            <option value="14:00:00">2PM</option>
                            <option value="15:00:00">3PM</option>
                            <option value="16:00:00">4PM</option>
                            <option value="17:00:00">5PM</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
        </div>

        <div class="form-group">
            <label for="duration">Duration</label>
            <select name="duration" name="duration" class="form-control" id="duration" required>
                <option value="" selected disabled>- select duration -</option>
                <option value="10">10 minutes</option>
                <option value="20">20 minutes</option>
                <option value="30">30 minutes</option>
                <option value="40">40 minutes</option>
                <option value="50">50 minutes</option>
                <option value="60">1 hour</option>
            </select>
            <br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Apply</button><br><br>
        </div>
    </form>
@endsection