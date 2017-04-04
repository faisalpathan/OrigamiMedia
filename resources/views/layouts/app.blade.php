<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="/css/app.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="/css/sweetalert.css">


    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

        window.origamimedia = {

            url: '{{ config('app.url') }}',
            user : {

                id : {{ Auth::check() ? Auth::user()->id : 'null' }},
                authenticated : {{ Auth::check() ? 'true' : 'false' }}
            }
        };

    </script>
</head>
<body>
    <div id="app">

    @include('layouts.partials._navigation')

        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="/js/app.js"></script>
</body>
    
        <script
          src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
          integrity="sha256-k2WSCIexGzOj3Euiig+TlR8gA0EmPjuc79OEeY5L45g="
          crossorigin="anonymous"></script>
        <script 
          src="//cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js">   
        </script>
        <script type="text/javascript" src="/js/sweetalert.min.js"></script>
        <script 
          type="text/javascript" src="/js/misc.js"> 
        </script>

</html>
