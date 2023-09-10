@extends('layouts/master_resident')

@section('content')
    <a class="btn btn-secondary" href="resident-maintenance" title="Back to Maintenance Booking History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Maintenance Booking Details</h1><br>
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

    <table class="table table-registration-approval">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Maintenance Date</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance Time Slot</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Maintenance typee</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Applied Date</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Description</th>
            <td></td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                <div class="badge bg-success text-wrap" style="width: 6rem;">Applied</div>
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                <!--Cancel Button-->
                <form action="" method="post">
                    @csrf
                    @method('put')
                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel</button>
                </form>
            </td>
        </tr>
    </table>
@endsection