<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('layouts.head')

    <body>

        <the-app id="app"></the-app>

        @include('layouts.footer')

        @include('layouts.scripts')
    </body>
</html>
