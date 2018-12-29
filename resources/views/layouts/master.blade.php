<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Cookbook - @yield('title', 'Narrenhaus')</title>
    </head>

    <body>

        @section('navigation')
            <nav class="top">
                <ul>
                    <li><a href="{{ url('/') }}"><i class="home"></i>Home</a></li>
                    @auth
                        <li><a href="{{ url('/recipes/create') }}"><i class="plus-sign"></i>Rezept hinzufügen</a></li>
                    @endauth
                </ul>
            </nav>
        @show

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
