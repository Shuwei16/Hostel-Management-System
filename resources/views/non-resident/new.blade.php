@extends('layouts/master_non-resident')

@section('content')

    <h1>New Registration</h1><br>
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

    <!-- Application for new student is still closed -->
    @if ($semester === null)
        <p class="alert alert-danger">New hostel application is not available yet. Please wait for the next new semester.</p>

    <!-- New registration available -->
    @elseif ($registration == null || $registration->status == "Canceled" || $registration->status == "Failed" || $registration->status == "Payment Failed")
        <!-- No room available, close application -->
        @if ($availability === false)
            <p class="alert alert-danger">Sorry, all rooms are fully booked.</p>
        <!-- Application is still available, show registration form -->
        @else
            <form class="input-form" action="{{route('non-resident-new.post')}}" method="post">
                @csrf
                <input type="hidden" class="form-control" name="semester_id" id="semester_id" placeholder="semester_id" value="{{ $semester->semester_id }}">
                <input type="hidden" class="form-control" name="user_id" id="user_id" placeholder="user_id" value="{{auth()->user()->id}}">
                <div class="form-group">
                    <label for="semester">Semester</label>
                    <input type="text" class="form-control" name="semester" id="semester" placeholder="semester" value="{{ $semester->semester_name }}" disabled><br>
                </div>
                <div class="form-group">
                    <label for="duration">Duration</label>
                    <table class="col-2">
                        <tr>
                            <td>
                                <div class="form-group">
                                    <label for="start_date" class="sub-label">Start Date</label>
                                    <input type="text" class="form-control" name="start_date" id="start_date" placeholder="start_date" value="{{ $semester->start_date }}" disabled>
                                </div>
                            </td>
                            <td>
                                <div class="form-group">
                                    <label for="end_date" class="sub-label">End Date</label>
                                    <input type="text" class="form-control" name="end_date" id="end_date" placeholder="end_date" value="{{ $semester->end_date }}" disabled>
                                </div>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="text" class="form-control" name="price" id="price" placeholder="price" value="RM {{ $semester->price }}" disabled><br>
                </div>
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="name" value="{{auth()->user()->name}}" disabled><br>
                </div>
                <div class="form-group">
                    <label for="ic">IC/Passport</label>
                    <input type="text" class="form-control" name="ic" id="ic" placeholder="e.g. 990101-10-1234 or AB1234567" required><br>
                </div>
                <label for="student_card">Student Card Photo</label><br>
                <span style="font-size: 12px; color: grey">*Sample</span><br>
                <img style="margin-bottom: 10px" src="{{ asset('images/sample-student-card.jpg')}}" width="200"/>
                <div class="input-group mb-3">
                    <input type="file" class="form-control" name="student_card" id="student_card" accept="image/*">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" onclick="scanStudentCard()">Upload</button>
                    </div>
                </div>
                <div class="form-group">
                    <table class="col-2">
                        <tr>
                            <td>
                                <label for="student_id">Student ID</label>
                                <input type="text" class="form-control" name="student_card_no" id="student_card_no" placeholder="e.g. 22WMR00001" pattern="^\d{2}[A-Z]{3}\d{5}$" required>
                            </td>
                            <td>
                                <label for="citizenship">Citizenship</label>
                                <select name="citizenship" name="citizenship" class="form-control" id="citizenship">
                                    <option value="">- select citizenship -</option>
                                    <option value="Citizen">Citizen</option>
                                    <option value="Non-citizen">Non-citizen</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="form-group">
                    <table class="col-2">
                        <tr>
                            <td>
                                <label for="contact_no">Contact No.</label>
                                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="e.g. 0123456789" pattern="^\d{10,11}$" required>
                            </td>
                            <td>
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{auth()->user()->email}}" disabled>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="form-group">
                    <table class="col-2">
                        <tr>
                            <td>
                                <label for="gender">Gender</label>
                                <select name="gender" name="gender" class="form-control" id="gender">
                                    <option value="">- select gender -</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </td>
                            <td>
                                <label for="race">Race</label>
                                <select name="race" name="race" class="form-control" id="race">
                                    <option value="">- select race -</option>
                                    <option value="Chinese">Chinese</option>
                                    <option value="Malay">Malay</option>
                                    <option value="Indian">Indian</option>
                                    <option value="Other">Other</option>
                                </select>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <div class="form-group">
                    <label for="programme">Programme Name</label>
                    <input type="text" class="form-control" name="programme" id="programme" placeholder="e.g. Bachelor's of Software Engineering" required><br>
                </div>
                <div class="form-group">
                    <table class="col-2">
                        <tr>
                            <td>
                                <label for="total_year">Total Year of Study</label>
                                <input type="number" class="form-control" name="total_year" id="total_year" placeholder="e.g. 3" pattern="[1-9]" required>
                            </td>
                            <td>
                                <label for="current_year">Current Year of Study</label>
                                <input type="number" class="form-control" name="current_year" id="current_year" placeholder="e.g. 1" pattern="[1-9]" required>
                            </td>
                        </tr>
                    </table>
                    <br>
                </div>
                <br>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" name="terms_and_conditions" id="terms_and_conditions" required>
                    <label class="form-check-label" for="terms_and_conditions">
                        I agree with all the <a href="">terms and conditions</a>.
                    </label>
                </div>
                <br>
                <div class="btn-submit">
                    <button type="submit">Apply</button><br><br>
                </div>
            </form>
        @endif

    <!-- Registration have been made -->
    @else 
        <p class="alert alert-primary">You have alrealy registered for this semester. Click <a href="{{route('non-resident-approval', ['id'=>$registration->registration_id])}}">here</a> to view details.</p>
    @endif

    <script src='https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js'></script>
    <script>
        function scanStudentCard() {
            // Get the input element
            var input = document.getElementById('student_card');
            const file = input.files[0];

            (async () => {
                const worker = await Tesseract.createWorker('eng');
                const { data: { text } } = await worker.recognize(file);
                console.log(text);

                const pattern = /[A-Z]?\d{2}[A-Z]{3}\d{5}/;
                const match = text.match(pattern);

                if (match) {
                    const result = match[0];
                    document.getElementById('student_card_no').value = result;
                    console.log("Result:", result);
                } else {
                    console.log("Pattern not found");
                }

                await worker.terminate();
            })();
        } 
    </script>
@endsection