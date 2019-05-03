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
        @extends('layouts.javascript')          {{--   JavaScripts    --}}
        @extends('layouts.style')               {{--      Style       --}}
        @extends('layouts.footer')              {{--      Footer      --}}
        @extends('layouts.content')             {{--   Main content   --}}
        @extends('layouts.header')              {{--    Main header   --}}
        @extends('layouts.noscript')            {{--   Noscript info  --}}
        @extends('layouts.navigation')          {{--  Main navigation --}}
        @extends('layouts.toast')               {{--  Toast messagess --}}
        @extends('layouts.modal')               {{--     Modal Box    --}}
    </body>

</html>
