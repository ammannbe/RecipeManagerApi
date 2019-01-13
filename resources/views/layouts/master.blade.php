<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <title>Cookbook - @yield('title', 'Narrenhaus')</title>

        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="/logo.png" type="image/x-icon">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <script
            src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous"></script>
        <script src="{{ mix('/js/app.js') }}"></script>
    </head>

    <body>
        <div class="toast">
            @include('toast::messages')
        </div>

        @section('navigation')
            <nav class="top">
                <ul>
                    <li><a href="{{ url('/') }}"><i class="home"></i>Home</a></li>
                    <li><a href="{{ url('/search') }}"><i class="magnifier"></i>Suche</a></li>
                    @auth
                        <li><a href="{{ url('/recipes/create') }}"><i class="plus-sign"></i>Rezept</a></li>
                        <li><a href="{{ url('/recipes/import') }}"><i class="plus-sign"></i>Import</a></li>
                    @endauth
                </ul>
            </nav>
        @show

        <div class="noscript">
            <noscript>
                Aktiviere JavaScript um von allen Funktionen zu profitieren.
            </noscript>
        </div>

        <header>
            <h1>@yield('title')</h1>
        </header>

        <section class="content @yield('class')">
            @yield('content')
        </section>

        {{-- Authentication Links --}}
        @section('navigation-right')
            <nav class="right">
                <ul>
                    @guest
                        <li>
                            <a href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <a href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="{{ url('/profile') }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Account <span class="caret"></span>
                            </a>
                        </li>

                        <li>
                            <div aria-labelledby="navbarDropdown">
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </nav>
        @show

        <footer>
            <em>&copy; 2018 - {{ date('Y') }}</em> <a href="{{ Request::root() }}">Narrenhaus Cookbook</a>
        </footer>

    </body>

</html>
