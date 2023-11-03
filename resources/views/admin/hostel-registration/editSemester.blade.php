@extends('layouts/master_admin')

@section('content')
    <a class="btn btn-secondary" href="{{route('admin-viewSemester', ['id'=>$semester->semester_id])}}" title="Back to Semester Details"><i class="fa fa-angle-left" aria-hidden="true"></i> Back</a><br><br>
    <h1>Edit Semester</h1><br>

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

    <form class="input-form" action="{{route('admin-editSemester.post', ['id'=>$semester->semester_id])}}" method="post">
        @csrf
        <div class="form-group">
            <label for="semester">Semester</label>
            <table class="col-2">
                <tr>
                    <td>
                        <div class="form-group">
                            <label for="month" class="sub-label">Month</label>
                            <select name="month" name="month" class="form-control" id="month">
                                <option value="JANNUARY" {{ $month == "JANNUARY" ? 'selected' : '' }}>JANNUARY</option>
                                <option value="FEBRUARY" {{ $month == "FEBRUARY" ? 'selected' : '' }}>FEBRUARY</option>
                                <option value="MARCH" {{ $month == "MARCH" ? 'selected' : '' }}>MARCH</option>
                                <option value="APRIL" {{ $month == "APRIL" ? 'selected' : '' }}>APRIL</option>
                                <option value="MAY" {{ $month == "MAY" ? 'selected' : '' }}>MAY</option>
                                <option value="JUNE" {{ $month == "JUNE" ? 'selected' : '' }}>JUNE</option>
                                <option value="JULY" {{ $month == "JULY" ? 'selected' : '' }}>JULY</option>
                                <option value="AUGUST" {{ $month == "AUGUST" ? 'selected' : '' }}>AUGUST</option>
                                <option value="SEPTEMBER" {{ $month == "SEPTEMBER" ? 'selected' : '' }}>SEPTEMBER</option>
                                <option value="OCTOBER" {{ $month == "OCTOBER" ? 'selected' : '' }}>OCTOBER</option>
                                <option value="NOVEMBER" {{ $month == "NOVEMBER" ? 'selected' : '' }}>NOVEMBER</option>
                                <option value="DECEMBER" {{ $month == "DECEMBER" ? 'selected' : '' }}>DECEMBER</option>
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

                                @for ($y = $currentYear; $y <= $endYear; $y++)
                                    <option value="{{ $y }}"  {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
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
                            <input type="datetime-local" class="form-control" name="start_date" id="start_date" placeholder="{{ $semester->start_date }}" value="">
                        </div>
                    </td>
                    <td>
                        <div class="form-group">
                            <label for="end_date" class="sub-label">End Date</label>
                            <input type="datetime-local" class="form-control" name="end_date" id="end_date" placeholder="{{ $semester->end_date }}" value="">
                        </div>
                    </td>
                </tr>
            </table>
            <br>
        </div>
        <div class="form-group">
            <label for="price">Price (RM)</label>
            <input type="number" step="0.01" class="form-control" name="price" id="price" placeholder="0.00" value="{{ $semester->price }}"><br>
        </div>
        <br>
        <div class="btn-submit">
            <button type="submit">Edit</button><br><br>
        </div>
    </form>
@endsection