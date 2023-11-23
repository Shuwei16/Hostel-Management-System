<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Hostel Management System')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<style>
    html, body {
      margin: 0;
      padding: 0;
      height: 100%;
    }
    header {
        font-family: verdana, sans-serif;
        padding: 20px;
    }
    .header-content {
        width: 100%;
    }
    .header-content td {
        text-align: center;
        padding: 0 10px 0 10px;
    }
    .header-content img {
        width: 200px;
        vertical-align: middle;
    }
    .header-content span {
        font-size: 30px;
        padding: 0;
        margin: 0;
        vertical-align: middle;
        font-weight: bold;
    }
    .header-content button {
        font-family: verdana, sans-serif;
        background-color: #F9C03D;
        color: white;
        border: none;
        border-radius: 7px;
        width: 150px;
        padding: 10px 10px;
        transition: 0.5s;
    }
    .header-content button:hover {
        background-color: #facf6b;
        cursor: pointer;
    }
    .header-deco{
        background-color: #293952;
        height: 2px;
    }
    .content {
        text-align: center;
    }
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
    .print-report {
        margin-top: 50px;
        text-align: center;
    }
    .date {
        text-align: right;
    }
</style>
<header>
    <!-- Header content -->
    <table class="header-content">
        <tr>
            <td style="text-align: left;">
                <img src="{{ asset('images/tarumt-logo.png') }}" alt="Logo" >
                <span>Hostel</span>
            </td>
        </tr>
    </table>
    <p class="header-deco" id="header-deco"><p>
</header>
<body>
    <div class="content">
        <h1>Hostel Summary Report</h1><br/>

        <div class="container" id="print">
            <div class="date">Reported Date: {{now()}}</div><br/>
            
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
                        <p>New Rregistrations</p>
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
    </div>

    <!-- button print -->
    <div class="print-report" id="print-report"><button type="button" class="btn btn-info" onclick="printReport()"><i class="fa fa-print" aria-hidden="true"></i> Print</button></div>

    <script>
        function printReport() {
            var btnPrint = document.getElementById("print-report");
            btnPrint.style.visibility = 'hidden';
            window.print()
            btnPrint.style.visibility = 'visible';
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
    <script>
        var pieXValues = [];
        var pieYValues = [];
        var roomOccupancy = @json($roomOccupancy);
        var emptyRoom = 2000;
        for (var i = 0; i < roomOccupancy.length; i++) {
            pieXValues.push(roomOccupancy[i].gender);
        }
        pieXValues.push("Available");
        for (var i = 0; i < roomOccupancy.length; i++) {
            pieYValues.push(roomOccupancy[i].total_occupied_slots);
            emptyRoom--;
        }
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
    
</body>
</html>