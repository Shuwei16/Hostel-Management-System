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

        @media only screen and (max-width: 900px) {
            #video{
                width: 100%;
            }
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
    <div id="video-container" class="video-container">
        <h1>Show Your Face Here</h1><br/>
        <video id="video" autoplay muted width="800" height="600"></video>
        <form id="formSubmit" action="{{ route('admin-scanFace.post') }}" method="post">
            @csrf
            <input type="hidden" class="form-control" value="" id="recognizedLabel" name="recognizedLabel" required>
            <button id="btnSubmit" class="btn btn-info" type="submit" disabled><i class="fa fa-check" aria-hidden="true"></i>Record Attendance</button>
        </form>
    </div>
    
    <!-- Scripts for face recognition -->
    <script src="{{ asset('js/face-api.min.js') }}"></script>
    <script type="module">
        const video = document.getElementById("video");
        const videoContainer = document.getElementById("video-container");
        const MODEL_URI = "/models";
        Promise.all([
            faceapi.nets.ssdMobilenetv1.loadFromUri(MODEL_URI),
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

        async function getLabeledFaceDescriptions() {
            //Retrieve all the labels existed in the directory
            const labels = [];
            const subdirectories = @json($subdirectories);
            for (var i = 0; i < subdirectories.length; i++) {
                labels.push(subdirectories[i]);
            }
            
            return Promise.all(
                labels.map(async (label) => {
                const descriptions = [];
                for (let i = 1; i <= 4; i++) {
                    const img = await faceapi.fetchImage(`/labels/${label}/${i}.png`);
                    const detections = await faceapi
                    .detectSingleFace(img)
                    .withFaceLandmarks()
                    .withFaceDescriptor();
                    descriptions.push(detections.descriptor);
                }
                return new faceapi.LabeledFaceDescriptors(label, descriptions);
                })
            );
        }

        // Fetch labels dynamically from the server or read from a directory
        async function fetchLabels() {
            // Implement the logic to fetch labels dynamically (e.g., read from a directory)
            const response = await fetch('/labels'); // Modify this endpoint accordingly
            const labels = await response.json();
            return labels;
        }

        video.addEventListener("play", async () => {
            const labeledFaceDescriptors = await getLabeledFaceDescriptions();
            const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

            // Creating the canvas
            const canvas = faceapi.createCanvasFromMedia(video);

            // This will force the use of a software (instead of hardware accelerated)
            // Enable only for low configurations
            canvas.willReadFrequently = true;
            videoContainer.appendChild(canvas);

            // Resizing the canvas to cover the video element
            const canvasSize = { width: video.width, height: video.height-100 };
            faceapi.matchDimensions(canvas, canvasSize);

            setInterval(async () => {
                const detections = await faceapi
                .detectAllFaces(video)
                .withFaceLandmarks()
                .withFaceDescriptors();

                const resizedDetections = faceapi.resizeResults(detections, canvasSize);

                canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

                const results = resizedDetections.map((d) => {
                    return faceMatcher.findBestMatch(d.descriptor);
                });
                    results.forEach((result, i) => {
                    const box = resizedDetections[i].detection.box;
                    const drawBox = new faceapi.draw.DrawBox(box, {
                        label: result,
                });
                    drawBox.draw(canvas);
                    // Check if the recognized label is not "unknown"
                    if (result.label !== 'unknown') {
                        // Record recognized label
                        document.getElementById('recognizedLabel').value = result.label;
                        // Enable form submission
                        document.getElementById('btnSubmit').disabled = false;
                    } else {
                        // Disabled form submission
                        document.getElementById('btnSubmit').disabled = true;
                    }
                });
            }, 100);
        });
        
    </script>
@endsection