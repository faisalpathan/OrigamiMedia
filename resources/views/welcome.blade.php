<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="shortcut icon" href="{{{ asset('img/favicon.png') }}}">
        <title>{{ config('app.name', 'Origami Media') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>
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

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                animation: type 2s steps(13), blink 1s infinite alternate;
                overflow: hidden;
                white-space: nowrap;
                width: 11ch;
                border-right: 3px solid;
            }
            .fadeIn {
                animation: fadeIn 2s;
            }
            .wait-2s {

                animation-delay: 2s;
                animation-fill-mode: both;
            }

            @keyframes type {
                from {
                    width: 0;
                }
            }

            @keyframes blink {
                50% {
                    border-color: transparent;
                }
            }

            @keyframes fadeIn {
                from { opacity: 0;  }
                to { opacity: 1; }
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Origami Media
                </div>
                <h3 class="fadeIn wait-2s">DBIT NPL</h3>

               
            </div>
        </div>
    </body>
</html>
