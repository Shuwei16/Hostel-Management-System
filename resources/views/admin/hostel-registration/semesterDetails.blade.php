@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-semesters" title="Back to Semester List"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Semetser Details</h1>
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
            <th scope="row" class="table-secondary" style="width: 25%">Semester</th>
            <td>{{ $semester->semester_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Duration of Stay</th>
            <td>from {{ $semester->start_date }} until {{ $semester->end_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Price</th>
            <td>RM {{ $semester->price }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">New Registration Open Date</th>
            <td>{{ $semester->new_reg_open_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">New Registration Close Date</th>
            <td>{{ $semester->new_reg_close_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Extension Stay Registration Open Date</th>
            <td>{{ $semester->extension_reg_open_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Extension Stay Registration Close Date</th>
            <td>{{ $semester->extension_reg_close_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Earliest Check In Date</th>
            <td>{{ $semester->earliest_check_in_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Latest Check Out Date</th>
            <td>{{ $semester->latest_check_out_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                @php
                    use Carbon\Carbon;
                    $currentDate = now();
                    $startDate = Carbon::parse($semester->extension_reg_open_date);
                    $endDate = Carbon::parse($semester->new_reg_close_date);
                @endphp
                @if ($currentDate->gte($startDate) && $currentDate->lte($endDate))
                <div class="badge bg-success text-wrap" style="width: 6rem;">Registration Opened</div>
                @else
                <div class="badge bg-danger text-wrap" style="width: 6rem;">Registration Closed</div>
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                <!-- edit button -->
                <a class="btn btn-primary btn-sm btn-action" href="{{route('admin-editSemester', ['id'=>$semester->semester_id])}}" title="Edit Semester" style="font-size: 1vmax"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a>
                <!-- delete button -->
                <form action="{{ route('admin-semesters.delete', $semester->semester_id) }}" method="post">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-trash-o" aria-hidden="true"></i> Delete</button>
                </form>
            </td>
        </tr>
    </table>

@endsection