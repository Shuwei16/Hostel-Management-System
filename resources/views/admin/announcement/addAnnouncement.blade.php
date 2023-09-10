@extends('layouts/master_admin')
@section('content')
    <a class="btn btn-secondary" href="admin-announcement" title="Back to Announcements"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Add Announcement</h1>

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

    <form class="input-form" action="" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="" value=""><br>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea class="form-control" name="content" id="content" placeholder="" value="" rows="10" cols="50"></textarea><br>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" id="image" placeholder="" value=""><br>
        </div>

        <div class="form-group">
            <label for="publicity">Publicity</label>
            <select name="publicity" name="publicity" class="form-control" id="publicity">
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
                        <select name="announced_block" name="announced_block" class="form-control" id="announced_block">
                            <option value="All">All Block</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                        </select>
                    </td>
                    <td>
                        <label for="announced_gender">Announced Gender</label>
                        <select name="publicity" name="publicity" class="form-control" id="publicity">
                            <option value="All">All Gender</option>
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
@endsection