@extends('layouts/master_admin')
@section('content')
    <a class="btn btn-secondary" href="{{route('admin-announcementDetails', ['id'=>$announcement->announcement_id])}}" title="Back to Announcements Details"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Edit Announcement</h1>

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

    <form class="input-form" id="inputForm" action="{{route('admin-editAnnouncement.post', ['id'=>$announcement->announcement_id])}}" method="post">
        @csrf
        <input type="hidden" class="form-control" name="announcement_id" id="announcement_id" placeholder="" value="{{ $announcement->announcement_id }}" required>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="" value="{{ $announcement->title }}" required><br>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" placeholder="" value="{{ $announcement->content }}" rows="10" cols="50" required>{{ $announcement->content }}</textarea><br>
        </div>

        <div class="form-group">
            <label for="publicity" required>Publicity</label>
            <select name="publicity" name="publicity" class="form-control" id="publicity">
                <option value="">- select publicity -</option>
                <option value="Public" {{ $announcement->publicity == "Public" ? 'selected' : '' }} >Public</option>
                <option value="Private" {{ $announcement->publicity == "Private" ? 'selected' : '' }} >Private</option>
            </select>
            <br>
        </div>

        <div class="form-group">
            <table class="col-2">
                <tr>
                    <td>
                        <label for="announced_block">Announced Block</label>
                        <select name="announced_block" class="form-control" id="announced_block">
                            <option value="All" {{ $announcement->announced_block == "All" ? 'selected' : '' }} >All Block</option>
                            @foreach($blocks as $block)
                                <option value="{{$block->block_name}}" {{ $announcement->announced_block == $block->block_name ? 'selected' : '' }}>{{$block->block_name}}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <label for="announced_gender">Announced Gender</label>
                        <select name="announced_gender" class="form-control" id="announced_gender">
                            <option value="All" {{ $announcement->announced_gender == "All" ? 'selected' : '' }} >All Gender</option>
                            <option value="Male" {{ $announcement->announced_gender == "Male" ? 'selected' : '' }} >Male</option>
                            <option value="Female" {{ $announcement->announced_gender == "Female" ? 'selected' : '' }} >Female</option>
                        </select>
                    </td>
                </tr>
            </table>
            <br>
        </div>

        <br>
        <div class="btn-submit">
            <button type="button" onclick="formSubmission()">Edit</button><br><br>
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

        // Call the function to set the initial state based on the selected option
        toggleInputField();

        // Add an event listener to the "Publicity" dropdown to update the state when its value changes
        publicitySelect.addEventListener('change', toggleInputField);
        // Add an event listener to the "Announced Block" dropdown to update the state when its value changes
        announcedBlockSelect.addEventListener('change', toggleInputField);
        // Add an event listener to the "Announced Gender" dropdown to update the state when its value changes
        announcedGenderSelect.addEventListener('change', toggleInputField);

        function formSubmission() {
            // Display a confirmation dialog
            if (confirm('Are you sure to edit this announcement?')) {
                // If the user clicks "OK," submit the form
                document.getElementById('inputForm').submit();
            } else {
                // If the user clicks "Cancel," do nothing or provide additional handling
                event.preventDefault();
            }
        }
    </script>
@endsection