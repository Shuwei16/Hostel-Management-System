@extends('layouts/master_admin')

@section('content')
<style>
    .container {
        text-align: center;
    }
    .col-sm {
        text-align: center;
        border: 1px solid #CCCCCC;
        padding: 10px;
    }
    #video, canvas {
        width: 100%;
        height: auto;
        background-color: #EFEFEF;
    }
    input {
        text-align: center;
        margin-bottom: 5px;
    }
</style>
    <a class="btn btn-secondary" href="admin-vehicleParkingPassApps" title="Back to Parking Application History"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Verify Vehicle</h1><br>

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <p>Step 1: Take photo of the car plate</p>
                <div class="camera">
                    <video id="video">Video stream not available.</video>
                </div>
                <button id="startbutton" class="btn btn-info"><i class="fa fa-camera" aria-hidden="true"></i> Take photo</button>
            </div>
            <div class="col-sm">
                <p>Step 2: Verify the car plate number</p>
                <canvas id="canvas"> </canvas>
                <input type="text" class="form-control" name="plate_no" id="plate_no" required>
                <button id="verify" class="btn btn-success" onclick="" disabled><i class="fa fa-check-circle-o" aria-hidden="true"></i> Verify</button>
            </div>
        </div>
        <div class="row">
            
        </div>
        <br>
    </div>

    <script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>
    <script>
        /* take photo by webcam */
        const width = 600;
        let height = 0;
        let streaming = false;
        let video = null;
        let canvas = null;
        let startbutton = null;

        function showViewLiveResultButton() {
            if (window.self !== window.top) {
            document.querySelector(".contentarea").remove();
            const button = document.createElement("button");
            button.textContent = "View live result of the example code above";
            document.body.append(button);
            button.addEventListener("click", () => window.open(location.href));
            return true;
            }
            return false;
        }

        function startup() {
            if (showViewLiveResultButton()) {
            return;
            }
            video = document.getElementById("video");
            canvas = document.getElementById("canvas");
            startbutton = document.getElementById("startbutton");

            navigator.mediaDevices
            .getUserMedia({ video: true, audio: false })
            .then((stream) => {
                video.srcObject = stream;
                video.play();
            })
            .catch((err) => {
                console.error(`An error occurred: ${err}`);
            });

            video.addEventListener(
            "canplay",
            (ev) => {
                if (!streaming) {
                height = video.videoHeight / (video.videoWidth / width);
                if (isNaN(height)) {
                    height = width / (4 / 3);
                }

                video.setAttribute("width", width);
                video.setAttribute("height", height);
                canvas.setAttribute("width", width);
                canvas.setAttribute("height", height);
                streaming = true;
                }
            },
            false,
            );

            startbutton.addEventListener(
            "click",
            (ev) => {
                takepicture();
                ev.preventDefault();
            },
            false,
            );

            clearphoto();
        }

        function clearphoto() {
            const context = canvas.getContext("2d");
            context.fillStyle = "#AAA";
            context.fillRect(0, 0, canvas.width, canvas.height);

            const data = canvas.toDataURL("image/png");
        }

        function takepicture() {
            const context = canvas.getContext("2d");
            if (width && height) {
                canvas.width = width;
                canvas.height = height;
                context.drawImage(video, 0, 0, width, height);

                const data = canvas.toDataURL("image/png");

                /* scan car plate */
                (async () => {
                    const worker = await Tesseract.createWorker('eng');
                    const { data: { text } } = await worker.recognize(data, {
                        type: 'image/png',
                    });
                    console.log(text);
                
                    const test ="JFC 2218";
                    const pattern = /[A-Z]{1,3}\s\d{1,4}(\s[A-Z])?/;
                    const match = text.match(pattern);

                    if (match) {
                        const result = match[0];
                        document.getElementById('plate_no').value = result;
                        console.log("Result:", result);
                    } else {
                        console.log("Pattern not found");
                    }

                    await worker.terminate();
                })();

                document.getElementById("verify").disabled = false;
            } else {
                clearphoto();
            }
        }

        window.addEventListener("load", startup, false);
    </script>
@endsection