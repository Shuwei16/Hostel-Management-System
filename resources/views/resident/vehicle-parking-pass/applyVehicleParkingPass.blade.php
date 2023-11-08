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

    <!-- Check whether have applied parking pass -->
    @if ($appliedPass !== null)
        <p class="alert alert-danger">You have already applied for a vehicle parking pass.</p>
    @else
        <form class="input-form" action="{{ route('resident-applyVehicleParkingPass.post') }}" method="post" onsubmit="confirm('Are you sure to apply parking pass for this vehicle?')">
            @csrf
            <div class="form-group">
                <label for="make">Make</label>
                <input type="text" class="form-control" name="make" id="make" placeholder="e.g. Perodua" value="" required><br>
            </div>

            <div class="form-group">
                <label for="model">Model</label>
                <input type="text" class="form-control" name="model" id="model" placeholder="e.g. Axia" value="" required><br>
            </div>

            <div class="form-group">
                <label for="year">Year</label>
                <input type="text" class="form-control" name="year" id="year" placeholder="e.g. 2023" pattern="\d{4}" value="" required><br>
            </div>

            <div class="form-group">
                <label for="select_color">Color</label>
                <select name="select_color" class="form-control" id="select_color">
                    <option value="" disabled selected>- select color -</option>
                    <option value="White">White</option>
                    <option value="Black">Black</option>
                    <option value="Silver">Silver</option>
                    <option value="Grey">Grey</option>
                    <option value="Red">Red</option>
                    <option value="Orange">Orange</option>
                    <option value="Yellow">Yellow</option>
                    <option value="Green">Green</option>
                    <option value="Blue">Blue</option>
                    <option value="Purple">Purple</option>
                    <option value="Pink">Pink</option>
                    <option value="Other">Other</option>
                </select>
                <input type="hidden" class="form-control" name="color" id="color" placeholder="Input your own color" value="" required><br>
            </div>

            <div class="form-group">
                <label for="plate_no">Plate No</label>
                <input type="text" class="form-control" name="plate_no" id="plate_no" placeholder="e.g. WWW1234" value="" required><br>
            </div>

            <br>
            <div class="btn-submit">
                <button type="submit">Apply</button><br><br>
            </div>
        </form>

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
    @endif
@endsection