@extends('layouts/master_non-resident')

@section('content')
    <a class="btn btn-secondary" href="non-resident-history" title="Back to Registration History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Registration Approval</h1><br>
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

    <table class="table table-details">
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Semester</th>
            <td>{{ $registration->semester_name }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Duration of Stay</th>
            <td>from {{ $registration->start_date }} until {{ $registration->end_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Registration Type</th>
            <td>{{ $registration->registration_type }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Registration Date</th>
            <td>{{ $registration->registration_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Room</th>
            <td>{{ $registration->room_code }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Price</th>
            <td>RM {{ $registration->price }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Withdrawal and Rebate Date</th>
            <td>{{ $registration->withdrawal_due_date }}</td>
        </tr>
        @if($registration->status == "Pending Payment")
        <tr>
            <th scope="row" class="table-secondary">Payment Due Date</th>
            <td>{{ $registration->payment_due_date }}</td>
        </tr>
        @endif
        @if($registration->payment_date !== null)
        <tr>
            <th scope="row" class="table-secondary">Payment Date</th>
            <td>{{ $registration->payment_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Earliest Check-In Date</th>
            <td>{{ $registration->start_date }}</td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Latest Check-Out Date</th>
            <td>{{ $registration->end_date }}</td>
        </tr>
        @endif
        <tr>
            <th scope="row" class="table-secondary">Information</th>
            <td></td>
        </tr>
        @if($registration->check_in_date !== null)
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Check In Date</th>
            <td>{{ $registration->check_in_date }}</td>
        </tr>
        @endif
        @if($registration->check_out_date !== null)
        <tr>
            <th scope="row" class="table-secondary" style="width: 25%">Check Out Date</th>
            <td>{{ $registration->check_out_date }}</td>
        </tr>
        @endif
        <tr>
            <th scope="row" class="table-secondary">Status</th>
            <td>
                @if($registration->status == "Pending Payment")
                    <div class="badge bg-warning text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @elseif($registration->status == "Failed" || $registration->status == "Canceled" || $registration->status == "Payment Failed")
                    <div class="badge bg-danger text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @else
                    <div class="badge bg-success text-wrap" style="width: 6rem;">{{ $registration->status }}</div>
                @endif
            </td>
        </tr>
        <tr>
            <th scope="row" class="table-secondary">Action</th>
            <td>
                @if($registration->status == "Pending Payment")
                    <!--Make Payment Button-->
                    <button type="button" class="btn btn-info btn-sm btn-action" onclick="window.location.href = '{{route('non-resident-payment', ['id'=>$registration->registration_id])}}'">Make Payment <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    
                    @if($withdrawAvailability == true)
                    <!--Cancel Button-->
                    <form action="{{ route('non-resident-approval.cancel', $registration->registration_id) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel Registration</button>
                    </form>
                    @endif

                @elseif($registration->status == "Failed" || $registration->status == "Canceled" || $registration->status == "Payment Failed")
                    <!--Re Apply Button-->
                    <button type="button" class="btn btn-info btn-sm btn-action" onclick="window.location.href = 'non-resident-new'">Apply Again <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                
                @else

                    <!--View Receipt Button-->
                    <a class="btn btn-info btn-sm btn-action" href="{{ route('payment-receipt', ['id'=>$registration->registration_id]) }}" target="_blank">View Receipt <i class="fa fa-arrow-right" aria-hidden="true"></i></a>
                    
                    @if($withdrawAvailability == true)
                    <!--Cancel Button-->
                    <form action="{{ route('non-resident-approval.cancel', $registration->registration_id) }}" method="post">
                        @csrf
                        @method('put')
                        <button type="submit" class="btn btn-danger btn-sm btn-action"><i class="fa fa-times" aria-hidden="true"></i> Cancel Registration</button>
                    </form>
                    @endif

                @endif
            </td>
        </tr>
    </table>

@endsection