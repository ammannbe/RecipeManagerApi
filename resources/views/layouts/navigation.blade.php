@php($w3BarItemClasses = 'w3-bar-item w3-button w3-mobile w3-padding-large')

<div class="w3-bar w3-black nav top">
    <a href="{{ url('/') }}" class="{{ $w3BarItemClasses }}"><i class="home"></i>Übersicht</a>
    <a href="{{ url('/search') }}" class="{{ $w3BarItemClasses }}"><i class="magnifier"></i>Suche</a>
    @auth
        <a href="{{ url('/recipes/create') }}" class="{{ $w3BarItemClasses }}">Rezept eingeben</a>
    @endauth


    @guest
        <a href="{{ route('login') }}" class="{{ $w3BarItemClasses }} w3-right w3-grey"><i></i>Login</a>
    @else
        <div class="w3-dropdown-hover w3-mobile w3-right">
            <button class="w3-button w3-padding-large dropdown-button">Account<i class="black-down-pointing-triangle"></i></button>
            <div class="w3-dropdown-content w3-bar-block w3-dark-grey">
                <a href="{{ url('/profile') }}" class="{{ $w3BarItemClasses }}">Profil</a>

                @if (auth()->user()->user_type == 'admin')
                    <a href="{{ url('/admin') }}" class="{{ $w3BarItemClasses }}">Administration</a>
                @endif

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="submit" value="Abmelden" class="w3-button">
                </form>
            </div>
        </div>
    @endguest
</div>
