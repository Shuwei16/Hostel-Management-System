@extends('layouts/master_admin')

@section('content')
    <style>
        .video-container {
            position: relative;
            text-align: center;
        }

        canvas {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>

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

    <a class="btn btn-secondary" href="admin-attendance" title="Back to Resident Attendance"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <div id="video-container" class="video-container">
        <h1>Show Your Face Here</h1>
        <video id="video" autoplay muted width="600" height="600"></video>
    </div>
    
    <!-- Scripts for face recognition -->
    <script>
        const video = document.getElementById("video");
        const videoContainer = document.getElementById("video-container");
        const MODEL_URI = "/models";
        Promise.all([
            faceapi.nets.tinyFaceDetector.loadFromUri(MODEL_URI),
            faceapi.nets.faceLandmark68Net.loadFromUri(MODEL_URI),
            faceapi.nets.faceRecognitionNet.loadFromUri(MODEL_URI),
            faceapi.nets.faceExpressionNet.loadFromUri(MODEL_URI),
            faceapi.nets.ageGenderNet.loadFromUri(MODEL_URI),
        ]).then(playVideo)
            .catch((err) => {
            console.log(err);
        });

        function playVideo() {
        if (!navigator.mediaDevices) {
            console.error("mediaDevices not supported");
            return;
        }
        navigator.mediaDevices
            .getUserMedia({
            video: {
                width: { min: 640, ideal: 1280, max: 1920 },
                height: { min: 360, ideal: 720, max: 1080 },
            },
                audio: false,
            })
                .then(function (stream) {
                video.srcObject = stream;
            })
                .catch(function (err) {
                console.log(err);
            });
        }
        video.addEventListener("play", () => {
        // Creating the canvas
        const canvas = faceapi.createCanvasFromMedia(video);

        // This will force the use of a software (instead of hardware accelerated)
        // Enable only for low configurations
        canvas.willReadFrequently = true;
        videoContainer.appendChild(canvas);

        // Resizing the canvas to cover the video element
        const canvasSize = { width: video.width, height: video.height-200 };
        faceapi.matchDimensions(canvas, canvasSize);

        setInterval(async () => {
            const detections = await faceapi
            .detectAllFaces(video, new faceapi.TinyFaceDetectorOptions())
            .withFaceLandmarks()
            .withFaceExpressions()
            .withAgeAndGender();

            // Set detections size to the canvas size
            const DetectionsArray = faceapi.resizeResults(detections, canvasSize);
            canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
            detectionsDraw(canvas, DetectionsArray);
        }, 10);
        });

        // Drawing our detections above the video
        function detectionsDraw(canvas, DetectionsArray) {
        // Adjust the size of the detection canvas
        faceapi.draw.drawDetections(canvas, DetectionsArray);
        //faceapi.draw.drawFaceLandmarks(canvas, DetectionsArray);
        faceapi.draw.drawFaceExpressions(canvas, DetectionsArray);

        // Drawing AGE and GENDER
        DetectionsArray.forEach((detection) => {
            const box = detection.detection.box;
            const drawBox = new faceapi.draw.DrawBox(box, {
            label: `${Math.round(detection.age)}y, ${detection.gender}`,
            });
            drawBox.draw(canvas);
        });
        }
    </script>
@endsection