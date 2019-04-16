<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{-- This is the master layout, where the base layout structure is defined. --}}

    <head>
        <title>@yield('title', 'Narrenhaus') - {{ env('APP_NAME') }}</title>

        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="@yield('meta-description')">
    </head>

    <body>
        {{-- @extends are in a reversed order, so the files are rendered in a correct order --}}

        @extends('layouts.footer')              {{--      Footer      --}}
        @extends('layouts.content')             {{--   Main content   --}}
        @extends('layouts.header')              {{--    Main header   --}}
        @extends('layouts.noscript')            {{--   Noscript info  --}}
        @extends('layouts.navigation')          {{--  Main navigation --}}
        @extends('layouts.toast')               {{--  Toast messagess --}}

        <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
		<script src="{{ asset('js/select2-4.0.1.min.js') }}"></script>
        <script src="{{ mix('/js/app.js') }}"></script>

        <link rel="stylesheet" href="{{ asset('css/select2-4.0.1.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/w3-4.12.css') }}">
        <link rel="shortcut icon" href="/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
    </body>

</html>
