<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Instagram') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/solid.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('fontawesome/css/font-awesome.min.css') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @stack('css')
</head>
<body>

    <style>

        .navbar{

            height:  77px;
            background-color: white;

        }
        .logo{

                position: relative;
            top: 0px;

        }
         ._2dbep {
                background-color: #fafafa;
                border-radius: 50%;
                -webkit-box-sizing: border-box;
                box-sizing: border-box;
                display: block;
                -webkit-box-flex: 0;
                -webkit-flex: 0 0 auto;
                -ms-flex: 0 0 auto;
                flex: 0 0 auto;
                overflow: hidden;
                position: relative;
        }

        .show-users{
                position: absolute;
                z-index: 9999;
                margin-left: 16.2%;
                margin-top: 3%;
                border: 1px solid white;
                background-color: #ffffff;
                border-radius: 5px;
                width: 190px;
        }
        .i-item{
            padding-bottom: 0px;
            padding-left: 5px;
            padding-top: 0px;
            font-size: 15px;
            padding-right: 60px;
        }
        .image-search{
                width: 40px;
                height: 40px;
                margin-right:  15px;
        }

        .i-border-bottom{
            border-bottom: 1px solid #f7f7f7;
        }
        .bg-hover:hover{
            background-color: #f8f9fa;
        }
        .photoNote{
            width: 50px;
            height: 50px;
            border-radius: 27px
        }
        .readNoti{
            font-size: 10px;
            display: none;
            margin-left: 129px;
            cursor: pointer;
            color: blue;
        }
        .readNoti:hover{
            text-decoration: underline;
        }
    </style>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/home') }}">
                    <img class="logo" src="{{ asset('image/logo.png') }}" alt="Instagram Logo">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                            <form  method="get" accept-charset="utf-8" style="margin-left: 15em;">
                            <input type="text" id="search" name="search" class="form-control" placeholder="Search">

                            </form>

                             <div class="show-users" aria-labelledby="dropdownMenuButton">


                              </div>


                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>

                        @else

                            <li class="nav-item dropdown">

                                <a id="FollowDropdown" class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <span  style="font-size: 25px;" class="fa fa-heart-o notificationIcon"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right notification" aria-labelledby="FollowDropdown">
                                    @foreach(auth()->user()->unreadnotifications as $notification)
                                        <a class="dropdown-item" href="{{ url('users/'.$notification->data['username']) }} ">
                                            <img class="photoNote" src="{{asset('profile/'.$notification->data['photo'])}}" alt="">
                                               <small>{{$notification->data['username']}}</small> <small>Start following</small>
                                        </a>
                                    @endforeach

                                    <span class="readNoti" >Mark All as Read</span>
                                </div>
                            </li>
                            <li class="nav-item dropdown">

                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item" href="{{ url('users/'.Auth::user()->username) }} ">

                                        {{ __('Profile') }}
                                    </a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>


                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                         </li>


                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

</body>
<script src="{{ asset('js/app.js') }}" ></script>
   @stack('js')
   @stack('jsforpage')
   <script>
       $(document).ready(function() {

            $('#search').focus(function(event) {
                $('.show-users').slideDown();
            });

           $('#search').blur(function(event) {
                $('.show-users').slideUp();
            });
           $('#search').keyup(function() {
               var search = $('#search').val();


               if(search !== null){
                   $.ajax({
                       url: '{{ url('users/search') }}',
                       type: 'get',
                       dataType: 'json',
                       data: {search: search},
                   })
                   .done(function(data) {
                    if (data!==null) {
                        var showUsers = '';
                        for (var i = 0; i < data.length; i++) {

                         showUsers +=  '<li class="i-border-bottom bg-hover"><a class="dropdown-item i-item" href="{{ url('users') }}/'+data[i].username+'"><img src="{{ asset('profile') }}/'+data[i].image+'" class="image-search">'+data[i].name+'</a></li>';

                        }
                        $('.show-users').html(showUsers);

                    }


                   })


               }
           });

           function notification(){
             if ($('.notification').children().length > 1){
               $('.readNoti').css("display",'block');
                $('.notificationIcon').css("color",'red');
             }
           }

            notification();

            $('#FollowDropdown').click(function () {
               $.ajax({
                   url: '{{ url('notification/Mark-All') }}',
                   type: 'get',
                   dataType: 'json',
               })
                   .done(function(data) {


                   })

            });


//             setInterval(function(){
//                   $.ajax({
//                    url: '{{ url('notification/get-noti') }}',
//                    type: 'get',
//                    dataType: 'json',
//                })
//                    .done(function(data) {
// //console.log(data['notification']);
//                     $('.notification').html(data['notification']);

//                         if ($('.notification').children().length >= 1){

//                            $('.readNoti').css("display",'block');
//                             $('.notificationIcon').css("color",'red');
//                           }
//                    })
//             },4000)



       });


   </script>
</html>
