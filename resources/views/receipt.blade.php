<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hostel Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    header {
        font-family: verdana, sans-serif;
        padding: 20px;
    }
    .header-content {
        width: 100%;
    }
    .header-content td {
        text-align: center;
        padding: 0 10px 0 10px;
    }
    .header-content img {
        width: 200px;
        vertical-align: middle;
    }
    .header-content span {
        font-size: 30px;
        padding: 0;
        margin: 0;
        vertical-align: middle;
        font-weight: bold;
    }
    .header-content button {
        font-family: verdana, sans-serif;
        background-color: #F9C03D;
        color: white;
        border: none;
        border-radius: 7px;
        width: 150px;
        padding: 10px 10px;
        transition: 0.5s;
    }
    .header-content button:hover {
        background-color: #facf6b;
        cursor: pointer;
    }
    .header-deco{
        background-color: #293952;
        height: 2px;
    }
    .content {
        text-align: center;
    }
    .table-details {
        width: 70%;
        margin: auto;
        box-shadow: 10px 10px 20px #CDD7DF;
        text-align: left;
    }
    .print-receipt {
        margin-top: 50px;
        text-align: center;
    }
</style>
<header>
    <!-- Header content -->
    <table class="header-content">
        <tr>
            <td style="text-align: left;">
                <img src="{{ asset('images/tarumt-logo.png') }}" alt="Logo" >
                <span>Hostel</span>
            </td>
        </tr>
    </table>
    <p class="header-deco" id="header-deco"><p>
</header>
<body>
    <div class="content">
        <h1>Receipt</h1><br/>

        <table class="table table-details">
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Receipt No.</th>
                <td>{{ $payment->receipt_no }}</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Name</th>
                <td>{{ $payment->name }}</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Description</th>
                <td>Hostel Fee</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Registration Type</th>
                <td>{{ $payment->description }}</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Bill Amount</th>
                <td>RM {{ $payment->amount }}</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Payment Method</th>
                <td>{{ $payment->payment_method }}</td>
            </tr>
            <tr>
                <th scope="row" class="table-secondary" style="width: 25%">Payment Date</th>
                <td>{{ $payment->payment_date }}</td>
            </tr>
        </table>
    </div>

    <!-- button print -->
    <div class="print-receipt" id="print-receipt"><button type="button" class="btn btn-info" onclick="printReceipt()"><i class="fa fa-print" aria-hidden="true"></i> Print Receipt</button></div>

    <script>
        function printReceipt() {
            var btnPrint = document.getElementById("print-receipt");
            btnPrint.style.visibility = 'hidden';
            window.print()
            btnPrint.style.visibility = 'visible';
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    
</body>
</html>