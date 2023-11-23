@extends('layouts/master_admin')

@section('content')
<style>
    .col-sm, .col-sm-6 {
        margin: 10px 0px;
        text-align: center;
    }
    .content1 {
        background-color: #EFEFEF;
        border-radius: 5px;
        padding: 10px;
        height: 100%;
    }
    .content1 p {
        font-size: 14px;
        text-align: left;
    }
    .content1 span {
        font-size: 20px;
        font-weight: bold;
        line-height: 1;
        margin: none;
        padding: none;
    }
    .chart-container {
        text-align: center;
    }
    .chart {
        background-color: white;
        width: 100%;
        max-width: auto;
    }
</style>
    <h1>Dashboard <a class="btn btn-primary" href="admin-printReport" target="_blank" title="Print Report" style="font-size: 1vmax; float: right;"><i class="fa fa-print" aria-hidden="true"></i> Print Report</a></h1><br/>

    <div class="container" id="print">
        <div class="row">
            <div class="col-sm">
                <div class="content1">
                    <p>Semester</p>
                    <span>{{$semester->semester_name}}</span>
                </div>
            </div>
            <div class="col-sm">
                <div class="content1">
                    <p>Duration</p>
                    <span>{{$semester->start_date}} -<br/> {{$semester->end_date}}</span>
                </div>
            </div>
            <div class="col-sm">
                <div class="content1">
                    <p>Total Registrations</p>
                    <span>{{$totalRegistrations}}</span>
                </div>
            </div>
            <div class="col-sm">
                <div class="content1">
                    <p>New Registrations</p>
                    <span>{{$newRegistrations}}</span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="content1">
                    <p>Room Occupancy In This Semester</p>
                    <div class="chart-container"><canvas id="pieChart" class="chart"></canvas></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="content1">
                    <p>Occupancy Trend Over Semesters</p>
                    <div class="chart-container"><canvas id="lineChart" class="chart"></canvas></div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        var pieXValues = [];
        var pieYValues = [];
        var roomOccupancy = @json($roomOccupancy);
        var emptyRoom = 2000;
        for (var i = 0; i < roomOccupancy.length; i++) {
            pieXValues.push(roomOccupancy[i].gender);
            pieYValues.push(roomOccupancy[i].total_occupied_slots);
            emptyRoom = emptyRoom - roomOccupancy[i].total_occupied_slots;
        }
        pieXValues.push("Available");
        pieYValues.push(emptyRoom);
        //var pieXValues = ["Italy", "France", "Spain", "USA", "Argentina"];
        //pieYValues = [55, 49, 44];
        var barColors = [
        "#b91d47",
        "#2b5797",
        "#00aba9"
        ];

        new Chart("pieChart", {
            type: "doughnut",
            data: {
                labels: pieXValues,
                datasets: [{
                backgroundColor: barColors,
                data: pieYValues
                }]
            },
            options: {
                title: {
                display: true
                }
            }
        });

        const lineXValues = [];
        const lineYValues = [];
        var semOccupancy = @json($semOccupancy);
        for (var i = 0; i < semOccupancy.length; i++) {
            lineXValues.push(semOccupancy[i].semester_name);
        }
        for (var i = 0; i < semOccupancy.length; i++) {
            lineYValues.push(semOccupancy[i].total_number);
        }
        //const lineXValues = [50,60,70,80,90,100,110,120,130,140,150];
        //const lineYValues = [7,8,8,9,9,9,10,11,14,14,15];

        new Chart("lineChart", {
            type: "line",
            data: {
                labels: lineXValues,
                datasets: [{
                fill: false,
                lineTension: 0,
                backgroundColor: "rgba(0,0,255,1.0)",
                borderColor: "rgba(0,0,255,0.1)",
                data: lineYValues
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                yAxes: [{ticks: {min: 0, max:2000}}],
                }
            }
        });
    </script>
@endsection