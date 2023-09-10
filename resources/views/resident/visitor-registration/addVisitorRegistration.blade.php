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

    <form class="input_form" action="" method="post">
        @csrf

        <div class="form-group">
            <label for="visitor_name">Visitor Name</label>
            <input type="text" class="form-control" name="visitor_name" id="visitor_name" placeholder="" value="" required><br>
        </div>

        <div class="form-group">
            <label for="visit_purpose">Purpose</label>
            <textarea class="form-control" name="visit_purpose" id="visit_purpose" placeholder="" value="" rows="5" cols="50" requried></textarea><br>
        </div>

        <div class="form-group">
            <table class="col-2">
                <tr>
                    <td>
                        <label for="visit_date">Visit Date</label>
                        <input type="datetime-local" class="form-control" name="visit_date" id="visit_date" placeholder="- select date -" value="">
                    </td>
                    <td>
                        <label for="announced_gender">Visit Time</label>
                        <select name="visit_time" name="visit_time" class="form-control" id="visit_time">
                            <option value="">- select time -</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
        </div>

        <div class="form-group">
            <label for="duration">Duration (Minutes)</label>
            <input type="number" class="form-control" name="duration" id="duration" placeholder="" value="" required><br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Apply</button><br><br>
        </div>
    </form>
@endsection