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
        .btn-payment {
            width: 25%;
            margin: 10px;
        }
    </style>


    <a class="btn btn-secondary" href="{{route('non-resident-approval', ['id'=>$id])}}" title="Back to Registration Approval"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Payment</h1><br>
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

    <form class="input-form" action="{{route('non-resident-payment-method')}}" method="post">
        @csrf
        <div class="form-group payment-desc">
            Payment Description: Hostel Fee </br>
            Total Amount: <span class="payment-amount">RM {{ $amount }}</spam>
        </div>

        <h4>Choose Payment Method</h4></br>

        <input type="hidden" class="btn-check" name="id" id="id" value="{{ $id }}">
        <input type="hidden" class="btn-check" name="amount" id="amount" value="{{ $amount }}">

        <div class="form-group payment-method">
            <input type="radio" class="btn-check" name="payment_method" id="card" value="Card" autocomplete="off" checked>
            <label class="btn btn-outline-dark btn-payment" for="card"><i class="fa fa-credit-card" aria-hidden="true"></i> <i class="fa fa-cc-visa" aria-hidden="true"></i> <i class="fa fa-cc-mastercard" aria-hidden="true"></i> <i class="fa fa-paypal" aria-hidden="true"></i></br>Credit / Debit Card</label>

            <input type="radio" class="btn-check" name="payment_method" id="online_banking" value="Online Banking" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="online_banking"><i class="fa fa-university" aria-hidden="true"></i></br>Online Banking</label>

            <input type="radio" class="btn-check" name="payment_method" id="ewallet" value="E-Wallet" autocomplete="off">
            <label class="btn btn-outline-dark btn-payment" for="ewallet"><i class="fa fa-usd" aria-hidden="true"></i> <i class="fa fa-money" aria-hidden="true"></i></br>E-Wallet</label>
        </div>

        <br/>
        <div class="btn-submit">
            <button type="submit">Continue</button><br><br>
        </div>
    </form>

@endsection