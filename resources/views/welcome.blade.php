<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{!! asset('template/bower_components/bootstrap/dist/css/bootstrap.min.css')!!}">

        <title>Presensi DTE</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Lato:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
            body {
                background: url('/images/bg.jpeg') no-repeat center center fixed;
                -webkit-background-size: cover;
                -moz-background-size: cover;
                background-size: cover;
                -o-background-size: cover;
            }

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;

            }
            .top-left {
                position: absolute;
                left: 10px;
                top: 18px;

            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 42px;
                color: #a9fd00;
                font-weight: normal;
            }

            .links > a {
                color: #a9fd00;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }


        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-left links">
                    <a href="/" class="logo">
                        <span class="logo-lg"><b>Presensi </b>DTE</span>
                    </a>
                </div>
                <div class="top-right links">
                    @auth
                        <a href="{{ route('logout') }}" class="btn " onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Presensi Mahasiswa<br>Departemen Teknik Elektro
                </div>
                <div class="row">
                    @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}" class="btn btn-lg" style="color: #a9fd00;background-color: #0a0a0a; width: 200px">Home</a>

                            @else
                                <a href="{{ route('login') }}" class="btn btn-lg" style="color: #a9fd00;background-color: #0a0a0a;width: 200px">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-lg" style="color: #a9fd00;background-color: #0a0a0a; width: 200px">Register</a>
                            @endauth
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </body>
</html>
