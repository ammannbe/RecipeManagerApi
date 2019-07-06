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

        <meta property="og:title" content="@yield('title', 'Narrenhaus')">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:description" content="@yield('meta-description')">
        <meta property="og:image" content="@yield('meta-image', url('/logo.png'))">
        <meta property="og:type" content="website">
        <meta property="og:locale" content="de_CH">
        <meta property="og:locale:alternate" content="de_DE">
        <meta property="og:locale:alternate" content="de_AT">
        <meta property="og:locale:alternate" content="en_US">
        <meta property="og:locale:alternate" content="en_GB">
    </head>

    <body>
        {{-- @extends are in a reversed order, so the files are rendered in a correct order --}}
        @extends('layouts.javascript')          {{--   JavaScripts    --}}
        @extends('layouts.footer')              {{--      Footer      --}}
        @extends('layouts.content')             {{--   Main content   --}}
        @extends('layouts.header')              {{--    Main header   --}}
        @extends('layouts.noscript')            {{--   Noscript info  --}}
        @extends('layouts.navigation')          {{--  Main navigation --}}
        @extends('layouts.toast')               {{--  Toast messagess --}}
        @extends('layouts.modal')               {{--     Modal Box    --}}
        @extends('layouts.style')               {{--      Style       --}}
    </body>

</html>
