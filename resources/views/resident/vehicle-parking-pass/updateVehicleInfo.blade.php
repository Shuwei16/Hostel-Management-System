@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="{{route('resident-vehicleParkingPassDetails', ['id'=>$application->parking_application_id])}}" title="Back to Vehicle Parking Pass Application Details"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Update Vehicle Information</h1><br>
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

    <form class="input-form" action="{{ route('resident-updateVehicleInfo.post', ['id'=>$application->parking_application_id])}}" method="post" onsubmit="confirm('Are you sure to update the vehicle info?')">
        @csrf
        <input type="hidden" class="form-control" name="id" id="id" value="{{ $application->parking_application_id }}">

        <div class="form-group">
            <label for="make">Make</label>
            <input type="text" class="form-control" name="make" id="make" placeholder="e.g. Perodua" value="{{ $application->make }}" required><br>
        </div>

        <div class="form-group">
            <label for="model">Model</label>
            <input type="text" class="form-control" name="model" id="model" placeholder="e.g. Axia" value="{{ $application->model }}" required><br>
        </div>

        <div class="form-group">
            <label for="year">Year</label>
            <input type="text" class="form-control" name="year" id="year" placeholder="e.g. 2023" value="{{ $application->year }}" required><br>
        </div>

        <div class="form-group">
            <label for="select_color">Color</label>
            <select name="select_color" class="form-control" id="select_color">
                <option value="" disabled>- select color -</option>
                <option value="White" @if($application->color == 'White') selected @endif>White</option>
                <option value="Black" @if($application->color == 'Black') selected @endif>Black</option>
                <option value="Silver" @if($application->color == 'Silver') selected @endif>Silver</option>
                <option value="Grey" @if($application->color == 'Grey') selected @endif>Grey</option>
                <option value="Red" @if($application->color == 'Red') selected @endif>Red</option>
                <option value="Orange" @if($application->color == 'Orange') selected @endif>Orange</option>
                <option value="Yellow" @if($application->color == 'Yellow') selected @endif>Yellow</option>
                <option value="Green" @if($application->color == 'Green') selected @endif>Green</option>
                <option value="Blue" @if($application->color == 'Blue') selected @endif>Blue</option>
                <option value="Purple" @if($application->color == 'Purple') selected @endif>Purple</option>
                <option value="Pink" @if($application->color == 'Pink') selected @endif>Pink</option>
                <option value="Other" @if(!in_array($application->color, ['White', 'Black', 'Silver', 'Grey', 'Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Purple', 'Pink'])) selected @endif>Other</option>
            </select>
            <input @if(!in_array($application->color, ['White', 'Black', 'Silver', 'Grey', 'Red', 'Orange', 'Yellow', 'Green', 'Blue', 'Purple', 'Pink'])) type="text" @else type="hidden" @endif class="form-control" name="color" id="color" placeholder="Input your own color" value="{{ $application->color }}" required><br>
        </div>

        <div class="form-group">
            <label for="plate_no">Plate No</label>
            <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="plate_no" value="{{ $application->plate_no }}" required><br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Update</button><br><br>
        </div>

        <script>
            const selectColor = document.getElementById('select_color');
            const colorInput = document.getElementById('color');

            selectColor.addEventListener('change', function() {
                const selectedColor = selectColor.value;
                if (selectedColor === 'Other') {
                    colorInput.type = 'text';
                    colorInput.value = '';
                } else {
                    colorInput.type = 'hidden'; // Show the input field
                    colorInput.value = selectedColor;
                }
            });
        </script>
    </form>
@endsection