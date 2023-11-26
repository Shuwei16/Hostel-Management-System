@extends('layouts/master_admin')
@section('content')
    <style>
        .container {
            display: flex;
            justify-content: center;
        }
        .grid-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }
        .grid-item {
            width: 100%;
        }
        @media only screen and (max-width: 1000px) {
            .grid-container {
                grid-template-columns: repeat(2, 1fr);
            }
        }
        @media only screen and (max-width: 600px) {
            .grid-container {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>

    <h1>Security (CCTV)</h1><br/>

    <div class="container">
        <div class="grid-container">
            <div class="grid-item">
                <span>Gate (Main)</span>
                <video id="video1" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Gate (Back)</span>
                <video id="video2" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Chinese Canteen</span>
                <video id="video3" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Malay Canteen</span>
                <video id="video4" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block A</span>
                <video id="video5" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block B</span>
                <video id="video6" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block C</span>
                <video id="video7" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block D</span>
                <video id="video8" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block E</span>
                <video id="video9" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block F</span>
                <video id="video10" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block G</span>
                <video id="video11" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block H</span>
                <video id="video12" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block I</span>
                <video id="video13" width="100%" height="auto" autoplay></video>
            </div>
            <div class="grid-item">
                <span>Block J</span>
                <video id="video14" width="100%" height="auto" autoplay></video>
            </div>
        </div>
    </div>
    
    <script>
        // Check if the browser supports WebRTC
        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            // Access the video
            navigator.mediaDevices.getUserMedia({ video: true })
                .then(function (stream) {
                    // Assign the stream to the video element
                    for (let i = 1; i <= 14; i++) {
                        var video = document.getElementById('video' + i);
                        video.srcObject = stream;
                    }
                })
                .catch(function (error) {
                    console.error('Error accessing video:', error);
                });
        } else {
            console.error('WebRTC is not supported in this browser.');
        }
    </script>
    
@endsection