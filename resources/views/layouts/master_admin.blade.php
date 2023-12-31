<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hostel Management System</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/favicon.ico') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
    <div class="sidebar-bg"></div>
    <div class="sidebar">
        <img src="{{ asset('images/tarumt-logo.png') }}" alt="Logo"> 
        <p>Hostel</p>
        <ul>
            <li onclick="window.location.href = 'admin-dashboard';">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                Dashboard
            </li>
            <li onclick="window.location.href = 'admin-announcement';">
                <i class="fa fa-bell-o" aria-hidden="true"></i>
                Annoucements
            </li>
            <li onclick="window.location.href = 'admin-registrationRecord';">
                <i class="fa fa-file-text-o" aria-hidden="true"></i>
                Hostel Registrations
            </li>
            <li onclick="window.location.href = 'admin-roomManagement';">
                <i class="fa fa-bed" aria-hidden="true"></i>
                Rooms
            </li>
            <li onclick="window.location.href = 'admin-todaysMaintenance';">
                <i class="fa fa-cogs" aria-hidden="true"></i>
                Room Maintenances
            </li>
            <li onclick="window.location.href = 'admin-vehicleParkingPassApps';">
                <i class="fa fa-product-hunt" aria-hidden="true"></i>    
                Vehicle Parking Pass
            </li>
            <li onclick="window.location.href = 'admin-visitorRegistration';">
                <i class="fa fa-users" aria-hidden="true"></i>
                Visitor Registerations
            </li>
            <li onclick="window.location.href = 'admin-attendance';">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                Residents' Attendances
            </li>
            <li onclick="window.location.href = 'admin-security';">
                <i class="fa fa-shield" aria-hidden="true"></i>
                Security
            </li>
            <li onclick="window.location.href = 'admin-message';">
                <i class="fa fa-comments" aria-hidden="true"></i>
                Messages
            </li>
        </ul>
    </div>
    <div class="content">
        <!-- Header content -->
        <table class="header-content">
            <tr>
                <td style="text-align: left;" class="mobile-menu">
                    <button class="btn-menu" onclick="showDropDownMenu()"><i class="fa fa-bars" aria-hidden="true"></i></button>
                </td>
                <td style="text-align: left;">
                    <span>Administration</span>
                </td>
                <td style="text-align: right;">
                    <div class="dropdown-profile">
                        <button class="dropbtn" type="button" onclick="dropdownFunction()">{{auth()->user()->name}}</button>
                        <div class="dropdown-content" id="dropdownMenu">
                            <ul>
                                <li onclick="window.location.href = '{{route('logout')}}';">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>
                                    Logout
                                </li>
                            </ul>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <div class="header-deco2"><div>
        <div class="menu-dropdown" id="mobile-menu">
            <div><img src="{{ asset('images/tarumt-logo.png') }}" alt="Logo">  Hostel</div>
            <ul>
                <li onclick="window.location.href = 'admin-dashboard';">
                    <i class="fa fa-list-alt" aria-hidden="true"></i>
                    Dashboard
                </li>
                <li onclick="window.location.href = 'admin-announcement';">
                    <i class="fa fa-bell-o" aria-hidden="true"></i>
                    Annoucements
                </li>
                <li onclick="window.location.href = 'admin-registrationRecord';">
                    <i class="fa fa-file-text-o" aria-hidden="true"></i>
                    Hostel Registrations
                </li>
                <li onclick="window.location.href = 'admin-roomManagement';">
                    <i class="fa fa-bed" aria-hidden="true"></i>
                    Rooms
                </li>
                <li onclick="window.location.href = 'admin-todaysMaintenance';">
                    <i class="fa fa-cogs" aria-hidden="true"></i>
                    Room Maintenances
                </li>
                <li onclick="window.location.href = 'admin-vehicleParkingPassApps';">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i>    
                    Vehicle Parking Pass
                </li>
                <li onclick="window.location.href = 'admin-visitorRegistration';">
                    <i class="fa fa-users" aria-hidden="true"></i>
                    Visitor Registerations
                </li>
                <li onclick="window.location.href = 'admin-attendance';">
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    Residents' Attendances
                </li>
                <li onclick="window.location.href = 'admin-security';">
                    <i class="fa fa-shield" aria-hidden="true"></i>
                    Security
                </li>
                <li onclick="window.location.href = 'admin-message';">
                    <i class="fa fa-comments" aria-hidden="true"></i>
                    Messages
                </li>
            </ul>
        </div>
        <!-- Page content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    <button id="topButton" class="top-button" onclick="scrollToTop()" title="Go to top">
        <i class="fa fa-arrow-up" aria-hidden="true"></i>
    </button>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
    //When the user clicks on the button, toggle between hiding and showing the dropdown content
    function dropdownFunction() {
        document.getElementById("dropdownMenu").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function(e) {
        if (!e.target.matches('.dropbtn')) {
            var dropdownMenu = document.getElementById("dropdownMenu");
            if (dropdownMenu.classList.contains('show')) {
                dropdownMenu.classList.remove('show');
            }
        }
    }

    function scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: "smooth"
        });
    }

    flatpickr("input[type=datetime-local]");

    //To show drop down menu for mobile view
    function showDropDownMenu() {
        var menu = document.getElementById("mobile-menu");
        if(menu.style.display == "none") {
            menu.style.display = "block";
        } else {
            menu.style.display = "none";
        }
    }
    </script>
</body>
@include('layouts/footer')
</html>