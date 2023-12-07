@extends('layouts/master_admin')

@section('content')
<style>
    .container {
        width: 50%;
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
    .detect-error {
        margin-top: 20px;
        display: none;
    }
    canvas {
        display: none;
    }
    input {
        text-align: center;
        margin-bottom: 5px;
    }
    span {
        font-size: 10px;
        color: grey;
    }
    @media only screen and (max-width: 1000px) {
        .container {
            width: 80%;
        }
    }
    @media only screen and (max-width: 800px) {
        .container {
            width: 100%;
        }
    }
</style>
    <a class="btn btn-secondary" href="admin-attendance" title="Back to Resident Attendance"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a>
    <a class="btn btn-primary" href="admin-scanFace" title="Scan Face" style="font-size: 1vmax; float: right;"><i class="fa fa-user" aria-hidden="true"></i> Scan Face</a><br><br>
    <h1>Scan Car Plate</h1><br>

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

    <div class="container">
        <div class="row">
            <div class="col-sm">
                <p>Step 1: Take photo of the car plate</p>
                <div class="camera">
                    <video id="video">Video stream not available.</video>
                </div>
                <button id="startbutton" class="btn btn-info"><i class="fa fa-camera" aria-hidden="true"></i> Take photo</button>
                <div id="detectError" class="detect-error alert alert-danger" style="width: 100%">Couldn't detect car plate number. Please try again.</div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <p>Step 2: Confirm the car plate number</p>
                <span>*Take photo again if the shown car plate number is incorrect.<span>
                <canvas id="canvas"> </canvas>
                <form class="" action="{{route('admin-scanCarPlate.post')}}" method="post">
                    @csrf
                    <input type="text" class="form-control" name="plate_no" id="plate_no" required>
                    <button id="verify" class="btn btn-success" type="submit" disabled><i class="fa fa-check-circle-o" aria-hidden="true"></i> Record Attendance</button>
                </form>
            </div>
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

                // Get the image data from the original canvas
                const imageData = context.getImageData(0, 0, width, height);
                const data = imageData.data;

                // Perform preprocessing on the image data
                preprocessImage(data, width, height);

                // Put the preprocessed image data back to the preprocessed canvas
                context.putImageData(imageData, 0, 0);

                // Convert the preprocessed canvas content to a data URL
                const preprocessedData = canvas.toDataURL("image/png");

                /* scan car plate */
                (async () => {
                    const worker = await Tesseract.createWorker('eng');
                    const { data: { text } } = await worker.recognize(preprocessedData, {
                        type: 'image/png',
                    });
                    console.log(text);

                    const pattern = /[A-Z]{1,3}\s?\d{1,4}(\s?[A-Z])?/;
                    const match = text.match(pattern);

                    if (match) {
                        const result = match[0];
                        // Remove blank spaces from the result
                        const cleanedResult = result.replace(/\s/g, '');
                        document.getElementById('plate_no').value = cleanedResult;
                        document.getElementById('detectError').style.display = "none";
                    } else {
                        document.getElementById('plate_no').value = "";
                        document.getElementById('detectError').style.display = "block";
                    }

                    await worker.terminate();
                })();

                document.getElementById("verify").disabled = false;
            } else {
                clearphoto();
            }
        }

        function preprocessImage(data, width, height) {
            // Example: Invert colors (turn white to black and black to white)
            for (let i = 0; i < data.length; i += 4) {
                data[i] = 255 - data[i]; // Invert red component
                data[i + 1] = 255 - data[i + 1]; // Invert green component
                data[i + 2] = 255 - data[i + 2]; // Invert blue component
            }

            // Example: Convert the image to grayscale (luminosity method)
            for (let i = 0; i < data.length; i += 4) {
                const luminosity = 0.21 * data[i] + 0.72 * data[i + 1] + 0.07 * data[i + 2];
                data[i] = luminosity;
                data[i + 1] = luminosity;
                data[i + 2] = luminosity;
            }

            // You can add more preprocessing steps as needed
        }

        window.addEventListener("load", startup, false);
    </script>
@endsection