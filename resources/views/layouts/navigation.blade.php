@php($w3BarAlwaysItemClasses = 'w3-bar-item w3-button w3-padding-large')
@php($w3BarMediumItemClasses = 'w3-bar-item w3-button w3-hide-medium w3-hide-small w3-padding-large')
@php($w3BarSmallItemClasses  = 'w3-bar-item w3-button w3-padding-large')

<div class="nav top">
    <div class="w3-bar w3-black">
        <div class="w3-bar-item w3-padding-large w3-hide-medium w3-hide-small">
            <a class="w3-black" href="{{ route('lang', 'de') }}">DE</a> |
            <a class="w3-black" href="{{ route('lang', 'en') }}">EN</a>
        </div>
        <a href="{{ route('home') }}" class="{{ $w3BarAlwaysItemClasses }}"><i class="home"></i>{{ __('navigation.home') }}</a>
        <a href="{{ route('search.index') }}" class="{{ $w3BarAlwaysItemClasses }}"><i class="magnifier"></i>{{ __('navigation.search') }}</a>
        @auth
            <a href="{{ route('recipes.create') }}" class="{{ $w3BarMediumItemClasses }}">{{ __('navigation.create') }}</a>
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.index') }}" class="{{ $w3BarMediumItemClasses }}">{{ __('navigation.admin') }}</a>
            @endif
        @endauth

        @guest
            <a href="{{ route('login') }}" class="{{ $w3BarMediumItemClasses }} w3-right w3-grey"><i></i>{{ __('navigation.login') }}</a>
        @else
            <a href="{{ route('user.index') }}" class="{{ $w3BarMediumItemClasses }} w3-right">{{ __('navigation.profile') }}</a>

            <form id="logout-form" action="{{ route('logout') }}" class="w3-hide-medium w3-hide-small w3-right" method="POST">
                @csrf
                <input type="submit" value="{{ __('navigation.logout') }}" class="w3-button">
            </form>
        @endguest

        <a href="javascript:void(0)" class="{{ $w3BarSmallItemClasses }} w3-right w3-hide-large" onclick="navigation()">&#9776;</a>
    </div>

    <div class="w3-bar-block w3-black w3-hide w3-hide-large mobile">
        @auth
            <a href="{{ route('recipes.create') }}" class="{{ $w3BarSmallItemClasses }}">{{ __('navigation.create') }}</a>
            @if (auth()->user()->is_admin)
                <a href="{{ route('admin.index') }}" class="{{ $w3BarSmallItemClasses }}">{{ __('navigation.admin') }}</a>
            @endif
        @endauth

        @guest
            <a href="{{ route('login') }}" class="{{ $w3BarSmallItemClasses }} w3-grey"><i></i>{{ __('navigation.login') }}</a>
        @else
            <a href="{{ route('user.index') }}" class="{{ $w3BarSmallItemClasses }}">{{ __('navigation.profile') }}</a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="">
                @csrf
                <input type="submit" value="Abmelden" class="w3-button">
            </form>
        @endguest
        <div class="w3-bar-item w3-padding-large">
            <a class="w3-black" href="{{ route('lang', 'de') }}">DE</a> |
            <a class="w3-black" href="{{ route('lang', 'en') }}">EN</a>
        </div>
    </div>
</div>

<script>
    function navigation() {
        $('.mobile').toggleClass('w3-show');
    }
</script>
