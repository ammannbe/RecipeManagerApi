@extends('layouts.master')


@section('title', __('home.title'))
@section('meta-description', __('home.meta_description', ['count' => \App\Recipe::count()]))

@section('content-class', 'overview')
@section('content')

    @if ($newRecipes->count())
        <h2>{{ __('home.new_recipes') }}</h2>
        <div class="w3-row">
            @php
                $i = 0;
                $class = '';
            @endphp
            @foreach ($newRecipes as $recipe)
                @php
                    $i++;
                    if ($i >= 3)  { $class = 'w3-hide-medium'; }
                @endphp
                <article class="w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                    <a href="{{ route('recipes.show', $recipe->slug) }}">
                        <header class="w3-container w3-white w3-center" title="{{ $recipe->name }}">
                            <h3>{{ FormatHelper::shorten($recipe->name) }}</h3>
                        </header>

                        <div class="image">
                            <div class="w3-container w3-center w3-padding">
                                @if ($recipe->photo)
                                    <img class="w3-round" src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->name }}">
                                @else
                                    <img class="w3-round" src="{{ url('/images/placeholder.png') }}" alt="{{ $recipe->name }}">
                                @endif
                            </div>
                        </div>

                        <p class="w3-container w3-white instructions" title="{{ $recipe->instructions }}">
                            {{ $recipe->instructions }}
                        </p>

                        <footer class="w3-panel w3-border-top w3-padding">
                            @if ($recipe->preparation_time)
                                <div class="w3-col s4 m4 l4">
                                    <span>{{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</span>
                                </div>
                            @endif
                            @if (count($recipe->ratings) > 0)
                                <div class="w3-col s8 m8 l8">
                                    <div>
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $recipe->ratings->avg('stars'))
                                                <small><i class="star-on"></i></small>
                                            @else
                                                <small><i class="star-off"></i></small>
                                            @endif
                                        @endfor
                                        <small class="count">({{ count($recipe->ratings) }})</small>
                                    </div>
                                </div>
                            @endif
                        </footer>
                    </a>
                </article>
            @endforeach
            <h3>
                <a href="{{ route('categories.show', $recipe->category->slug) }}">
                    <i class="arrow-right">{{ __('home.others') }} {{ $recipe->category->name }}</i>
                </a>
            </h3>
        </div>

        <h2>{{ __('home.top_recipes') }}</h2>
        <div class="w3-row">
            @php
                $j = 0;
                $class = '';
            @endphp
            @foreach ($topRecipes as $recipe)
                @php
                    $j++;
                    if ($j >= 3)  { $class = 'w3-hide-medium'; }
                @endphp
                <article class="w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                    <a href="{{ route('recipes.show', $recipe->slug) }}">
                        <header class="w3-container w3-white w3-center" title="{{ $recipe->name }}">
                            <h3>{{ FormatHelper::shorten($recipe->name) }}</h3>
                        </header>

                        <div class="image">
                            <div class="w3-container w3-center w3-padding">
                                @if ($recipe->photo)
                                    <img class="w3-round" src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->name }}">
                                @else
                                    <img class="w3-round" src="{{ url('/images/placeholder.png') }}" alt="{{ $recipe->name }}">
                                @endif
                            </div>
                        </div>

                        <p class="w3-container w3-white instructions" title="{{ $recipe->instructions }}">
                            {{ $recipe->instructions }}
                        </p>

                        <footer class="w3-panel w3-border-top w3-padding">
                            <div class="w3-col s4 m4 l4">
                                @if ($recipe->preparation_time)
                                    <span>{{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</span>
                                @endif
                            </div>
                            <div class="w3-col s8 m8 l8">
                                @if (count($recipe->ratings) > 0)
                                    <div>
                                        @for ($i = 0; $i < 5; $i++)
                                            @if ($i < $recipe->ratings->avg('stars'))
                                                <small><i class="star-on"></i></small>
                                            @else
                                                <small><i class="star-off"></i></small>
                                            @endif
                                        @endfor
                                        <small class="count">({{ count($recipe->ratings) }})</small>
                                    </div>
                                @endif
                            </div>
                        </footer>
                    </a>
                </article>
            @endforeach
            <h3>
                <a href="{{ route('categories.show', $recipe->category->slug) }}">
                    <i class="arrow-right">{{ __('home.others') }} {{ $recipe->category->name }}</i>
                </a>
            </h3>
        </div>
    @else
        <p>
            <strong>{{ __('home.no_recipes') }}</strong><br>
            @auth
                <a href="{{ route('recipes.create') }}">{{ __('home.be_first') }}</a>
            @endauth
        </p>
    @endif

    @if ($ratings->count())
        <h2>{{ __('home.new_comments') }}</h2>
        <div class="w3-row">
            @php
                $k = 0;
                $class = '';
            @endphp
            @foreach ($ratings as $rating)
                @php
                    $k++;
                    if ($k >= 3)  { $class = 'w3-hide-medium'; }
                @endphp
                <article class="w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                    <a href="{{ route('recipes.show', $rating->recipe->slug) }}">
                        <header class="w3-container w3-white w3-center" title="{{ $rating->recipe->name }}">
                            <h3>{{ FormatHelper::shorten($rating->recipe->name) }}</h3>
                        </header>

                        <div class="image">
                            <div class="w3-container w3-center w3-padding">
                                @if ($rating->recipe->photo)
                                    <img class="w3-round" src="{{ url("/images/recipes/{$rating->recipe->photo}") }}" alt="{{ $rating->recipe->name }}">
                                @else
                                    <img class="w3-round" src="{{ url('/images/placeholder.png') }}" alt="{{ $rating->recipe->name }}">
                                @endif
                            </div>
                        </div>

                        <p class="w3-container w3-white rating-stars">
                            @if (count($recipe->ratings) > 0)
                                <div>
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $recipe->ratings->avg('stars'))
                                            <small><i class="star-on"></i></small>
                                        @else
                                            <small><i class="star-off"></i></small>
                                        @endif
                                    @endfor
                                </div>
                            @endif
                        </p>

                        <p class="w3-container w3-white rating" title="{{ "{$rating->ratingCriterion->name}: {$rating->comment}" }}">
                            <strong>{{ $rating->ratingCriterion->name }}:</strong> {{ $rating->comment }}
                        </p>
                    </a>
                </article>
            @endforeach
        </div>
    @endif

@endsection
