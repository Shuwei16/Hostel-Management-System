@extends('layouts/master_admin')

@section('content')
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

    <style>
    #preview{
        margin:auto;
        border: 2px solid #293952; /* Set the border color and width */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Add a shadow to make it stand out */
    }

    </style>
    <a class="btn btn-secondary" href="admin-visitorRegistration" title="Back to Visitor Registrations"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>

    <div style="text-align: center;">
        <h4>Show Visitor QR Code Here</h4>
        <video id="preview"></video>
    </div>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
    <script type="text/javascript">
        var scanner = new Instascan.Scanner({ video: document.getElementById('preview'), scanPeriod: 5, mirror: false });
        scanner.addListener('scan',function(content){
            if (content.startsWith("admin-visitorRegistrationDetails-")) {
                window.location.href = content + '/scan';
            } else {
                alert("Invalid qr code");
            }
        });
        Instascan.Camera.getCameras().then(function (cameras){
            if(cameras.length>0){
                scanner.start(cameras[0]);
                $('[name="options"]').on('change',function(){
                    if($(this).val()==1){
                        if(cameras[0]!=""){
                            scanner.start(cameras[0]);
                        }else{
                            alert('No Front camera found!');
                        }
                    }else if($(this).val()==2){
                        if(cameras[1]!=""){
                            scanner.start(cameras[1]);
                        }else{
                            alert('No Back camera found!');
                        }
                    }
                });
            }else{
                console.error('No cameras found.');
                alert('No cameras found.');
            }
        }).catch(function(e){
            console.error(e);
            alert(e);
        });
    </script>
    <!--
    <div class="btn-group btn-group-toggle mb-5" data-toggle="buttons">
    <label class="btn btn-primary active">
        <input type="radio" name="options" value="1" autocomplete="off" checked> Front Camera
    </label>
    <label class="btn btn-secondary">
        <input type="radio" name="options" value="2" autocomplete="off"> Back Camera
    </label>
    </div>
    -->
@endsection