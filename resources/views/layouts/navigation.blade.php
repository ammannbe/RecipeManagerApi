<nav class="top">
    <ul>
        <li><a href="{{ url('/') }}"><i class="home"></i>Home</a></li>
        <li><a href="{{ url('/search') }}"><i class="magnifier"></i>Suche</a></li>
        @auth
            <li><a href="{{ url('/recipes/create') }}"><i class="plus-sign"></i>Rezept</a></li>

            @if (Auth::user()->user_type == 'admin')
                <li><a href="{{ url('/recipes/import') }}"><i class="plus-sign"></i>Import</a></li>
            @endif
        @endauth
    </ul>
</nav>
