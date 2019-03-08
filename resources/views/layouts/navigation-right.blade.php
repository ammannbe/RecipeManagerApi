<nav class="right">
    <ul>
        @guest
            <li>
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
                <li>
                    <a href="{{ route('register') }}">Registrieren</a>
                </li>
            @endif
        @else
            @if (Auth::user()->user_type == 'admin')
                <li>
                    <a href="{{ url('/admin') }}">Administration</a>
                </li>
            @endif

            <li>
                <a href="{{ url('/profile') }}">Profil</a>
            </li>

            <li>
                <div>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                            Abmelden
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>
