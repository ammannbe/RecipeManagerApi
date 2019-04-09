<nav class="top">

    <input type="checkbox" id="nav-checkbox-top" class="forced hidden"/>
    <label for="nav-checkbox-top" class="nav-open">&#926;</label>

    <ul class="container">
        <li><a href="{{ url('/') }}"><i class="home"></i>Übersicht</a></li>
        <li><a href="{{ url('/search') }}"><i class="magnifier"></i>Suche</a></li>
        @auth
            <li><a href="{{ url('/recipes/create') }}">Rezept eingeben</a></li>
        @endauth
        @guest
            <li class="right">
                <a href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
        @else
            <li>
                <a href="{{ url('/profile') }}">Profil</a>
            </li>
            @if (auth()->user()->user_type == 'admin')
                <li class="desktop-hide right">
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
