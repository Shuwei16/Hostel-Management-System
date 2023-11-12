@extends('layouts/master_resident')

@section('content')
    <style>
        #progress {
            position: relative;
            margin-bottom: 30px;
        }
        #progress-bar {
            position: absolute;
            background: #F9C03D;
            height: 5px;
            width: 0%;
            top: 50%;
            left: 0;
        }
        #progress-num {
            margin: 0;
            padding: 0;
            list-style: none;
            display: flex;
            justify-content: space-between;
        }
        #progress-num::before {
            content: "";
            background-color: lightgray;
            position: absolute;
            top: 50%;
            left: 0;
            height: 5px;
            width: 100%;
            z-index: -1;
        }
        #progress-num .step {
            border: 3px solid lightgray;
            border-radius: 100%;
            width: 50px;
            height: 50px;
            line-height: 50px;
            text-align: center;
            background-color: #fff;
            font-family: sans-serif;
            font-size: 20px;  
            position: relative;
            z-index: 1;
        }
        #progress-num .step.active {
            border-color: #F9C03D;
            background-color: #F9C03D;
            color: #fff;
        }
        .btn-progress {
            background: lightgray;    
            border: none;
            border-radius: 3px;
            padding: 6px 12px;   
        }
        #video {
            
        }
        #canvas {
            display: none;
        }
        .camera {
            text-align: center;
        }
        #scan-face {
            
        }
        .contentarea {
            font-size: 16px;
            font-family: Arial;
            text-align: center;
        }
        @media only screen and (max-width: 900px) {
            #video{
                width: 100%;
            }
        }
    </style>

    <a class="btn btn-secondary" href="resident-profile" title="Back to Profile"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Record Face Idendity</h1><br>

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
    
	<div id="progress">
        <div id="progress-bar"></div>
        <ul id="progress-num">
            <li class="step">1</li>
            <li class="step">2</li>
            <li class="step">3</li>
            <li class="step">4</li>
        </ul>
    </div>
    <div class="camera">
        <video id="video" width="800">Video stream not available.</video><br/>
        <button id="scan-face" class="btn btn-info"><i class="fa fa-check" aria-hidden="true"></i>Take Photo</button>
        
        <form id="formSubmit" action="{{ route('resident-recordFace.post') }}" method="post">
            @csrf
            <input type="hidden" class="form-control" value="" id="photo1" name="photo1" required>
            <input type="hidden" class="form-control" value="" id="photo2" name="photo2" required>
            <input type="hidden" class="form-control" value="" id="photo3" name="photo3" required>
            <input type="hidden" class="form-control" value="" id="photo4" name="photo4" required>
            <button type="submit" id="finish" class="btn btn-success" style="display: none;"><i class="fa fa-check" aria-hidden="true"></i>Finish</button>
        </form>
    </div>
    <canvas id="canvas"></canvas>

    <script>
        const progressBar = document.getElementById("progress-bar");
        const btnScan = document.getElementById("scan-face");
        const btnFinish = document.getElementById("finish");
        const steps = document.querySelectorAll(".step");
        let active = 0;

        btnScan.addEventListener("click", () => {
            active++;
            if (active > steps.length) {
                active = steps.length;
            }
            updateProgress();
        });

        const updateProgress = () => {
            steps.forEach((step, i) => {
                if (i < active) {
                    step.classList.add("active");
                } else {
                    step.classList.remove("active");
                }
            });
            progressBar.style.width = ((active - 1) / (steps.length - 1)) * 100 + "%";
            if (active < steps.length) {
                btnScan.style.display = 'inline-block';
                btnFinish.style.display = 'none';
            } else {
                btnScan.style.display = 'none';
                btnFinish.style.display = 'inline-block';
            }
        };

        var width = 600; // We will scale the photo width to this
        var height = 0; // This will be computed based on the input stream

        var streaming = false;

        var video = null;
        var canvas = null;
        var scanFace = null;

        function startup() {
            video = document.getElementById('video');
            canvas = document.getElementById('canvas');
            scanFace = document.getElementById('scan-face');
            photo1 = document.getElementById('photo1');
            photo2 = document.getElementById('photo2');
            photo3 = document.getElementById('photo3');
            photo4 = document.getElementById('photo4');

            navigator.mediaDevices.getUserMedia({
                    video: true,
                    audio: false
                })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                })
                .catch(function(err) {
                    console.log("An error occurred: " + err);
                });

            video.addEventListener('canplay', function(ev) {
                if (!streaming) {
                    height = video.videoHeight / (video.videoWidth / width);

                    if (isNaN(height)) {
                        height = width / (4 / 3);
                    }

                    video.setAttribute('width', width);
                    video.setAttribute('height', height);
                    canvas.setAttribute('width', width);
                    canvas.setAttribute('height', height);
                    streaming = true;
                }
            }, false);

            scanFace.addEventListener('click', function(ev) {
                takepicture();
                ev.preventDefault();
            }, false);

            clearphoto();
        }


        function clearphoto() {
            var context = canvas.getContext('2d');
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            var data = canvas.toDataURL('image/png');
        }

        function takepicture() {
            var context = canvas.getContext('2d');
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                var data = canvas.toDataURL('image/png');

                // Set the value of the input field with the data URL
                if (!photo1.value) {
                    photo1.value = data;
                } else if (!photo2.value) {
                    photo2.value = data;
                } else if (!photo3.value) {
                    photo3.value = data;
                } else if (!photo4.value) {
                    photo4.value = data;
                }
                
            } else {
                clearphoto();
            }
        }

        window.addEventListener('load', startup, false);

    </script>

    
@endsection