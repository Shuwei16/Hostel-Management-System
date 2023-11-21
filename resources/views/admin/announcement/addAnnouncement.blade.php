@extends('layouts/master_admin')
@section('content')
    <a class="btn btn-secondary" href="{{route('admin-announcement')}}" title="Back to Announcements"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Add Announcement</h1>

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

    <form class="input-form" action="{{route('admin-addAnnouncement.post')}}" method="post" enctype="multipart/form-data" onsubmit="confirm('Are you sure to add this announcement?');">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="" value="" required><br>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" placeholder="" value="" rows="10" cols="50" required></textarea><br>
        </div>

        <div class="form-group">
            <label for="image">Poster</label>
            <input type="file" class="form-control" name="image" id="image" placeholder="" value="" accept=".jpg, .jpeg, .png"  required><br>
        </div>

        <div class="form-group">
            <label for="publicity">Publicity</label>
            <select name="publicity" class="form-control" id="publicity" required>
                <option value="">- select publicity -</option>
                <option value="Public">Public</option>
                <option value="Private">Private</option>
            </select>
            <br>
        </div>

        <div class="form-group">
            <table class="col-2">
                <tr>
                    <td>
                        <label for="announced_block">Announced Block</label>
                        <select name="announced_block" class="form-control" id="announced_block" required>
                            <option value="All" selected>All Block</option>
                            @foreach($blocks as $block)
                                <option value="{{$block->block_name}}">{{$block->block_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="announced_gender">Announced Gender</label>
                        <select name="announced_gender" class="form-control" id="announced_gender" required>
                            <option value="All" selected>All Gender</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" name="email_notification" id="email_notification">
            <label class="form-check-label" for="email_notification">
                Also send notification via email.
            </label>
        </div>

        <br>
        <div class="btn-submit">
            <button type="submit">Add</button><br><br>
        </div>
    </form>

    <script>
        const publicitySelect = document.getElementById('publicity');
        const announcedBlockSelect = document.getElementById('announced_block');
        const announcedGenderSelect = document.getElementById('announced_gender');

        // Function to enable or disable the other input fields based on the selected option
        function toggleInputField() {
            if (publicitySelect.value === 'Public') {
                announcedBlockSelect.value = 'All';
                announcedGenderSelect.value = 'All';
                announcedBlockSelect.disabled = true;
                announcedGenderSelect.disabled = true;
            } else {
                if (announcedBlockSelect.value !== 'All') {
                    announcedGenderSelect.value = 'All';
                    announcedGenderSelect.disabled = true;
                } else {
                    announcedGenderSelect.disabled = false;
                }

                if (announcedGenderSelect.value !== 'All') {
                    announcedBlockSelect.value = 'All';
                    announcedBlockSelect.disabled = true;
                } else {
                    announcedBlockSelect.disabled = false;
                }
            }
        }

        // Add an event listener to the "Publicity" dropdown to update the state when its value changes
        publicitySelect.addEventListener('change', toggleInputField);
        // Add an event listener to the "Announced Block" dropdown to update the state when its value changes
        announcedBlockSelect.addEventListener('change', toggleInputField);
        // Add an event listener to the "Announced Gender" dropdown to update the state when its value changes
        announcedGenderSelect.addEventListener('change', toggleInputField);

        // Add an event listener to the form to enable disabled fields before submission
        const form = document.querySelector('.input-form');
        form.addEventListener('submit', function () {
            announcedBlockSelect.disabled = false;
            announcedGenderSelect.disabled = false;
        });

        // Call the function to set the initial state based on the selected option
        toggleInputField();
        
    </script>
@endsection