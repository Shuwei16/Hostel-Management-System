@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="admin-semesters" title="Back to Semester List"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Add New Semester</h1><br>

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

    <form class="input-form" action="{{route('admin-addSemester.post')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="semester">Semester</label>
            <table class="col-2">
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="month" class="sub-label">Month</label>
                            <select name="month" name="month" class="form-control" id="month">
                                <option value="">- select month -</option>
                                <option value="JANNUARY">JANNUARY</option>
                                <option value="FEBRUARY">FEBRUARY</option>
                                <option value="MARCH">MARCH</option>
                                <option value="APRIL">APRIL</option>
                                <option value="MAY">MAY</option>
                                <option value="JUNE">JUNE</option>
                                <option value="JULY">JULY</option>
                                <option value="AUGUST">AUGUST</option>
                                <option value="SEPTEMBER">SEPTEMBER</option>
                                <option value="OCTOBER">OCTOBER</option>
                                <option value="NOVEMBER">NOVEMBER</option>
                                <option value="DECEMBER">DECEMBER</option>
                            </select>
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="year" class="sub-label">Year</label>
                            <select name="year" name="year" class="form-control" id="year">
                                <option value="">- select year -</option>
                                @php
                                    $currentYear = \Carbon\Carbon::now()->year;
                                    $endYear = $currentYear + 4;
                                @endphp

                                @for ($year = $currentYear; $year <= $endYear; $year++)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endfor
                            </select>
                        </div>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <div class="form-group">
            <label for="semester">Duration of Stay</label>
            <table class="col-2">
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="start_date" class="sub-label">Start Date</label>
                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" placeholder="- select date -" value="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="end_date" class="sub-label">End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date" id="end_date" placeholder="- select date -" value="">
                        </div>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <div class="form-group">
            <label for="price">Price (RM)</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="0.00" value=""><br>
        </div>
        <br>
        <div class="btn-submit">
            <button type="submit">Add</button><br><br>
        </div>
    </form>

@endsection