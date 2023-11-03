@extends('layouts/master_resident')

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
        .card-method-icon {
            height: 30px;
        }
        .btn-payment {
            width: 25%;
            margin: 10px;
        }
    </style>


    <a class="btn btn-secondary" href="{{route('resident-payment', ['id'=>$id])}}" title="Back to Payment"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Card Payment</h1><br>
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

    <form class="input-form" action="{{route('resident-confirm-payment')}}" method="post">
        @csrf
        <div class="form-group payment-desc">
            Payment Description: Hostel Fee <br/>
            Total Amount: <span class="payment-amount">RM {{ $amount }}</spam>
        </div>

        <h4>Enter your card information
        <img class="card-method-icon" src="{{ asset('images/visa.png') }}" alt="visa">
        <img class="card-method-icon" src="{{ asset('images/master-card.png') }}" alt="master card">
        <img class="card-method-icon" src="{{ asset('images/paypal.png') }}" alt="paypal">
        </h4>
        <br/>

        <input type="hidden" class="btn-check" name="id" id="id" value="{{ $id }}">
        <input type="hidden" class="btn-check" name="amount" id="amount" value="{{ $amount }}">
        <input type="hidden" class="btn-check" name="payment_method" id="payment_method" value="Card">
        
        <div class="form-group">
            <label for="card_holder_name">Card Holder Name</label>
            <input type="text" class="form-control" name="card_holder_name" id="card_holder_name" placeholder="e.g. Chole Lim" value="" required><br>
        </div>

        <div class="form-group">
            <label for="card_number">Card Number</label>
            <input type="text" class="form-control" name="card_number" id="card_number" placeholder="e.g. 1234123412341234" value="" pattern="^\d{16}$" required><br>
        </div>

        <div class="form-group">
            <table class="col-2">
                <tr>
                    <td>
                        <label for="expiry_date">Expiry Date</label>
                        <input type="text" class="form-control" name="expiry_date" id="expiry_date" placeholder="MM/YY" pattern="^(0[1-9]|1[0-2])\/\d{2}$" value="" required>
                    </td>
                    <td>
                        <label for="cvv">CVV</label>
                        <input type="text" class="form-control" name="cvv" id="cvv" placeholder="000" pattern="^\d{3}$" required>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" name="confirm_transaction" id="confirm_transaction" required>
            <label class="form-check-label" for="confirm_transaction">
                I confirmed to allow this transaction.
            </label>
        </div>
        <br/>
        <div class="btn-submit">
            <button type="submit">Make Payment</button><br><br>
        </div>
    </form>

@endsection