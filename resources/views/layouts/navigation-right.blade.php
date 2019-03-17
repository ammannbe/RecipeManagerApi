<nav class="right">

    @auth
        <input type="checkbox" id="nav-checkbox-right" class="forced hidden"/>
        <label for="nav-checkbox-right" class="nav-open">&#926;</label>
    @endauth

    <ul class="container">
        @guest
            <li>
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @else
            <li>
                <a href="{{ url('/profile') }}">Profil</a>
            </li>
            @if (auth()->user()->user_type == 'admin')
                <li>
                    <a href="{{ url('/admin') }}">Administration</a>
                </li>
            @endif
            <li>
                <div>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="submit" value="Abmelden">
                    </form>
                </div>
            </li>
        @endguest
    </ul>
</nav>
