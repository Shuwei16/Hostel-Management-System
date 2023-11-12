@extends('layouts/master_home')

@section('content')
    <style>
        .section1 {
            display: grid;
            grid-template-columns: 40% 60%;
            width: 90%;
            margin: auto;
            grid-column-gap: 40px;
            align-items: center;
            padding: 2%;
        }
        .desc {
            background-color: #EFEFEF;
            padding: 5%;
            border-radius: 20px;
            height: 100%;
        }
        .section1 button {
            font-family: verdana, sans-serif;
            background-color: #F9C03D;
            color: white;
            border: none;
            border-radius: 7px;
            width: 150px;
            padding: 10px 10px;
            transition: 0.5s;
        }
        .section1 button:hover {
            background-color: #facf6b;
        }
        .section1 img{
            width: 100%;
        }
        .section1 .pic, .desc{
            transition: 0.5s;
        }
        .section1 .pic:hover, .desc:hover{
            opacity: 0.8;
            transform: scale(0.9);
        }
        .section1 h4 {
            font-family: verdana, sans-serif;
            color: #FB9D58;
        }
        .section1 h6 {
            font-family: verdana, sans-serif;
        }
        .section1 p {
            text-align: justify;
            font-size: 12px;
            font-family: verdana, sans-serif;
        }
        .section2 h1 {
            text-align: center;
            font-family: verdana, sans-serif;
            color: #FB9D58;
        }
        .whatsNew {
            width: 100%;
            display: flex;
            overflow-x: scroll;
        }
        .whatsNew .whatsNew-content {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-gap: 30px;
            padding: 30px;
            flex: none;
            text-align: center;
        }
        .whatsNew .whatsNew-content span {
            width: 100%;
            transition: transform 0.5s;
            height: 500px;
            margin: 5px;
            border: none;
            border-radius: 5px;
        }
        .whatsNew .whatsNew-content span:hover {
            cursor: pointer;
            transform: scale(1.1);
        }
        .whatsNew .whatsNew-content img {
            width: 100%;
            height: 70%;
        }
        .whatsNew::-webkit-scrollbar{
            display: none;
        }
        .whatsNew-wrap{
            background-color: #EFEFEF;
            display: flex;
            align-items: center;
            justify-content: cenetr;
            margin: auto;
            padding: 0% 5%;
        }
        .btn-arrow {
            font-size: 5vmin; 
            opacity: 0.5;
            cursor: pointer;
            margin: 2px;
        }
        .poster {
            height: 70%;
        }
        .title {
            text-align: left;
            font-size: 3vmin;
            display: block;
        }
        .date {
            text-align: left;
            font-size: 2vmin;
            display: block;
        }
        .whatsNew a {
            text-decoration: none;
            color: #000000;
        }

        @media only screen and (max-width: 800px) {
            .whatsNew div {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media only screen and (max-width: 600px) {
            .section1 {
                grid-template-columns: 100%;
            }
            .desc {
                margin-bottom: 20px;
            }
            .whatsNew .whatsNew-content {
                grid-template-columns: repeat(1, 1fr);
            }
        }
    </style>
    
    <!-- Page content -->
    <div class="section1">
        <div class="desc">
            <h4>Welcome to TARUMT Hostel</h4>
            <h6>~ Your Home Away from Home!</h6>
            </br>
            <p>Comfort, convenience, and community come together to create an exceptional living experience. Our hostel is the perfect choice for students seeking a comfortable and vibrant accommodation solution. With a strong commitment to providing the best services and facilities.</p>
            <p>Available at the Kuala Lumpur Main Campus. The hostel consists of 10 blocks of 5-storey building with 1,000 standard rooms which can accommodate 2,000 students. Each room is on a twin-sharing basis with 400 rooms allocated for male and 600 rooms for female in separate blocks. Each floor has its own common bathrooms, toilets, pantry, water dispenser and drying area. Hostel availability is based on first-come-first-served basis.</p>
            <button type="button" onclick="window.location.href = 'signup';">Register Now</button>
        </div>
        <div class="pic">
            <img src="{{ asset('images/hostel.jpg') }}" alt="Hostel">
        </div>
    </div>
    <div class="section2">
        <h1 style="text-align: center;">What's New</h1>
        <div class="whatsNew-wrap">
            <span id="backBtn" class="btn-arrow"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></span>
            <div class="whatsNew">
                @for($i = 0; $i < count($announcements); $i=$i+3)
                <div class="whatsNew-content">
                    @for($j = 0; $j < 3; $j++)
                    <span class="card">
                    @if (isset($announcements[$i+$j]))
                        <a href="{{route('newsDetails', ['id'=>$announcements[$i+$j]->announcement_id])}}">
                            <img class="card-img-top poster" src="{{ asset('images/announcement/' . $announcements[$i+$j]->image) }}" alt="Poster">
                            <div class="card-body">
                                <h4 class="card-title title">
                                @php
                                    $title = $announcements[$i+$j]->title
                                @endphp
                                @if(strlen($title) > 45)
                                    {{ Str::limit($title, 45, '...') }}
                                @else
                                    {{ $title }}
                                @endif</h4>
                                <p class="card-text date">posted on {{ $announcements[$i+$j]->created_at }}</p>
                            </div>
                        </a>
                    @endif
                    </span>
                    @endfor
                </div>
                @endfor
            </div>
            <span id="nextBtn" class="btn-arrow"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></span>
        </div>
    </div>

    <script>
        let scrollContainer = document.querySelector(".whatsNew");
        let backBtn = document.getElementById("backBtn");
        let nextBtn = document.getElementById("nextBtn");

        scrollContainer.addEventListener("wheel", (evt) => {
            evt.preventDefault();
            scrollContainer.scrollLeft += evt.deltaY;
            scrollContainer.style.scrollBehavior = "auto";
        });

        nextBtn.addEventListener("click", ()=>{
            scrollContainer.style.scrollBehavior = "smooth";
            scrollContainer.scrollLeft += 900;
        });

        backBtn.addEventListener("click", ()=>{
            scrollContainer.style.scrollBehavior = "smooth";
            scrollContainer.scrollLeft -= 900;
        });
    </script>
@endsection