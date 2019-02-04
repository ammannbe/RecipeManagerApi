<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{-- This is the master layout, where the base layout structure is defined. --}}

    <head>
        <title>Cookbook - @yield('title', 'Narrenhaus')</title>

        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="{{ mix('/js/app.js') }}"></script>

        <link rel="shortcut icon" href="/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </head>

    <body>
        @extends('layouts.toast')               {{--  Toast messagess --}}
        @extends('layouts.navigation')          {{--  Main navigation --}}
        @extends('layouts.noscript')            {{--   Noscript info  --}}
        @extends('layouts.header')              {{--    Main header   --}}
        @extends('layouts.content')             {{--   Main content   --}}
        @extends('layouts.navigation-right')    {{-- Right navigation --}}
        @extends('layouts.footer')              {{--      Footer      --}}
    </body>

</html>
