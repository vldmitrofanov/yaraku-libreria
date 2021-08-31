<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Yaraku Libreria App</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,600,700">

        <link href="{{mix('css/app.css')}}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div id="app">
        @yield('content')
        </div>
        <script src="{{mix('/js/app.js')}}"></script>
    </body>
</html>
