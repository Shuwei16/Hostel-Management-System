@extends('layouts/master_resident')

@section('content')
    <style>
        .time-slot-containter {
            background-color: #F2F2F2;
            border-radius: 7px;
            width: 100%;
        }
        .time-slot-containter td {
            padding: 10px;
            text-align: center;
        }
        .time-slot {
            width: 90%;
            height: 100px;
        }
        .time-slot-small {
            width: 20px;
            height: 20px;
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

    <form class="input-form" action="" method="post">
        @csrf
        <div class="form-group">
            Some information here...
            </br></br></br>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <select name="date" name="date" class="form-control" id="date">
                <option value="">- select date -</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            </br>
        </div>

        <div class="form-group">
            <label for="time">Time Slot</label>
            <table class="time-slot-containter">
                <tr>
                    @for ($i = 0; $i < 6; $i++)
                        <td><button type="button" class="btn btn-success time-slot">Time Slot</button></td>
                    @endfor
                </tr>
            </table>
            <button type="button" class="btn btn-success time-slot-small"></button> Available
            <button type="button" class="btn btn-danger time-slot-small"></button> Not Available
            </br></br>
        </div>

        <div class="form-group">
            <label for="maintenance_type">Maintenance Type</label>
            <select name="maintenance_type" name="maintenance_type" class="form-control" id="maintenance_type">
                <option value="">- select maintenance type -</option>
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
            </br>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" placeholder="" value="" rows="5" cols="50"></textarea><br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Book</button><br><br>
        </div>
    </form>
@endsection