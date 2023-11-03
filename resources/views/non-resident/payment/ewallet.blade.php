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
        .ewallet-icon {
            width: 140px;
        }
        .btn-payment {
            width: 25%;
            margin: 10px;
        }
    </style>


    <a class="btn btn-secondary" href="{{route('non-resident-payment', ['id'=>$id])}}" title="Back to Payment"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>E-Wallet Payment <i class="fa fa-usd" aria-hidden="true"></i> <i class="fa fa-money" aria-hidden="true"></i></h1><br>
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

        <h4>Choose an e-wallet type</h4></br>

        <input type="hidden" class="btn-check" name="id" id="id" value="{{ $id }}">
        <input type="hidden" class="btn-check" name="amount" id="amount" value="{{ $amount }}">
        <input type="hidden" class="btn-check" name="payment_method" id="payment_method" value="E-Wallet">

        <div class="form-group payment-method">
            <input type="radio" class="btn-check" name="bank" id="boost" value="boost" autocomplete="off" checked>
            <label class="btn btn-outline-dark btn-payment" for="boost"><img class="ewallet-icon" src="{{ asset('images/ewallet/boost.png') }}" alt="boost"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="grabPay" value="grabPay" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="grabPay"><img class="ewallet-icon" src="{{ asset('images/ewallet/grabPay.png') }}" alt="grabPay"></label><br/>

            <input type="radio" class="btn-check" name="bank" id="tng" value="tng" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="tng"><img class="ewallet-icon" src="{{ asset('images/ewallet/tng.png') }}" alt="tng"></label><br/>
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