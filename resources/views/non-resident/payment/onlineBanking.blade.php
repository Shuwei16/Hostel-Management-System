@extends('layouts/master_non-resident')

@section('content')
    <style>
        .payment-desc {
            border-bottom: 2px solid #CDD7DF;
            padding: 20px;
            margin-bottom: 20px;
        }
        .payment-amount {
            font-size: 20px;
            font-weight: bold;
            color: #FB9D58;
        }
        .payment-method {
            text-align: center;
        }
        .bank-icon {
            width: 140px;
        }
        .btn-payment {
            width: 50%;
            margin: 10px;
        }
    </style>


    <a class="btn btn-secondary" href="{{route('non-resident-payment', ['id'=>$id])}}" title="Back to Payment"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Online Banking <i class="fa fa-university" aria-hidden="true"></i></h1><br>
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

    <form class="input-form" action="{{route('non-resident-confirm-payment')}}" method="post">
        @csrf
        <div class="form-group payment-desc">
            Payment Description: Hostel Fee </br>
            Total Amount: <span class="payment-amount">RM {{ $amount }}</spam>
        </div>

        <h4>Choose Bank</h4></br>

        <input type="hidden" class="btn-check" name="id" id="id" value="{{ $id }}">
        <input type="hidden" class="btn-check" name="amount" id="amount" value="{{ $amount }}">
        <input type="hidden" class="btn-check" name="payment_method" id="payment_method" value="Online Banking">

        <div class="form-group payment-method">
            <input type="radio" class="btn-check" name="bank" id="MayBank" value="MayBank" autocomplete="off" checked>
            <label class="btn btn-outline-dark btn-payment" for="MayBank"><img class="bank-icon" src="{{ asset('images/bank/maybank.png') }}" alt="maybank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="RHBBank" value="RHB Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="RHBBank"><img class="bank-icon" src="{{ asset('images/bank/rhb.png') }}" alt="rhb"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="HongLeongBank" value="Hong Leong Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="HongLeongBank"><img class="bank-icon" src="{{ asset('images/bank/hongLeongBank.png') }}" alt="hongLeongBank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="PublicBank" value="Public Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="PublicBank"><img class="bank-icon" src="{{ asset('images/bank/publicBank.png') }}" alt="publicBank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="AllianceBank" value="Alliance Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="AllianceBank"><img class="bank-icon" src="{{ asset('images/bank/allianceBank.png') }}" alt="allianceBank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="HSBCBank" value="HSBC Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="HSBCBank"><img class="bank-icon" src="{{ asset('images/bank/hsbc.png') }}" alt="hsbcBank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="AmBank" value="AmBank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="AmBank"><img class="bank-icon" src="{{ asset('images/bank/ambank.png') }}" alt="ambank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="CIMBBank" value="CIMB Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="CIMBBank"><img class="bank-icon" src="{{ asset('images/bank/cimb.jpg') }}" alt="cimbBank"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="BankIslam" value="Bank Islam" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="BankIslam"><img class="bank-icon" src="{{ asset('images/bank/bankIslam.jpg') }}" alt="bankIslam"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="AffinIslamicBank" value="Affin Islamic Bank" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="AffinIslamicBank"><img class="bank-icon" src="{{ asset('images/bank/affin.png') }}" alt="affinIslamicBank"></label><br/>
        </div>
        <br/>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" name="confirm_transaction" id="confirm_transaction" required>
            <label class="form-check-label" for="confirm_transaction">
                I confirmed to allow this transaction.
            </label>
        </div>
        <br/>
        <br/>

        <div class="btn-submit">
            <button type="submit">Make Payment</button><br><br>
        </div>
    </form>

@endsection