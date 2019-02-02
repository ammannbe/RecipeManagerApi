<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    {{-- This is the master layout, where the base layout structure is defined. --}}

    @extends('layouts.head')                    {{--     HTML Head    --}}

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
