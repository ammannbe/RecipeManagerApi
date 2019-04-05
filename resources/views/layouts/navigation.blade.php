<nav class="top">

    <input type="checkbox" id="nav-checkbox-top" class="forced hidden"/>
    <label for="nav-checkbox-top" class="nav-open">&#926;</label>

    <ul class="container">
        <li><a href="{{ url('/') }}"><i class="home"></i>Übersicht</a></li>
        <li><a href="{{ url('/search') }}"><i class="magnifier"></i>Suche</a></li>
        @auth
            <li><a href="{{ url('/recipes/create') }}">Rezept eingeben</a></li>
        @endauth
    </ul>
</nav>
