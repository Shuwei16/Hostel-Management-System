@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-vehicleParkingPass" title="Back to Vehicle Parking Pass Application History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Vehicle Parking Pass Application</h1><br>
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
            <label for="make">Make</label>
            <input type="text" class="form-control" name="make" id="make" placeholder="make" value="" required><br>
        </div>

        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" class="form-control" name="model" id="model" placeholder="model" value="" required><br>
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" name="year" id="year" placeholder="year" value="" required><br>
        </div>

        <div class="form-group">
            <label for="color">Color</label>
            <input type="text" class="form-control" name="color" id="color" placeholder="color" value="" required><br>
        </div>

        <div class="form-group">
            <label for="plate_no">Plate No</label>
            <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="plate_no" value="" required><br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Apply</button><br><br>
        </div>
    </form>
@endsection