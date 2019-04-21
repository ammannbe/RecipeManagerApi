@extends('layouts.master')


@section('title', 'Übersicht Rezepte')
@section('meta-description',
        'Weisst du nicht, was du heute Kochen sollst? ' .
        'Finde hier die besten Rezepte unter den ' . \App\Recipe::count() . ' aufgeführten Rezepten. ' .
        'Immer frisch. Immer aktuell. Immer gut.'
    )


@section('content-class', 'overview')
@section('content')

    <h2>Neuste Rezepte</h2>
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
            <article class="w3-animate-zoom w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                <a href="{{ url("/recipes/{$recipe->slug}") }}">
                    <header class="w3-container w3-white w3-center" title="{{ $recipe->name }}">
                        <h3>{{ FormatHelper::shorten($recipe->name) }}</h3>
                    </header>

                    <div class="image">
                        <div class="w3-container w3-center w3-padding">
                            <img class="w3-round" src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ "Rezept {$recipe->name}" }}">
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
                                    @for ($i = 0; $i < $recipe->ratings->avg('stars'); $i++)
                                        <small><i class="star-on"></i></small>
                                    @endfor
                                    <small class="count">({{ count($recipe->ratings) }})</small>
                                </div>
                            </div>
                        @elseif (count($recipe->ratings) <= 0 && !$recipe->preparation_time)
                            -
                        @endif
                    </footer>
                </a>
            </article>
        @endforeach
    </div>

    <h2>Beliebteste Rezepte</h2>
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
            <article class="w3-animate-zoom w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                <a href="{{ url("/recipes/{$recipe->slug}") }}">
                    <header class="w3-container w3-white w3-center" title="{{ $recipe->name }}">
                        <h3>{{ FormatHelper::shorten($recipe->name) }}</h3>
                    </header>

                    <div class="image">
                        <div class="w3-container w3-center w3-padding">
                            <img class="w3-round" src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ "Rezept {$recipe->name}" }}">
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
                                    @for ($i = 0; $i < $recipe->ratings->avg('stars'); $i++)
                                        <small><i class="star-on"></i></small>
                                    @endfor
                                    <small class="count">({{ count($recipe->ratings) }})</small>
                                </div>
                            @endif
                        </div>
                    </footer>
                </a>
            </article>
        @endforeach
    </div>

    <h2>Neuste Kommentare</h2>
    @if ($ratings)
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
                <article class="w3-animate-zoom w3-col w3-container w3-hover-shadow w3-card s12 m6 l3 {{ $class }}">
                    <a href="{{ url("/recipes/{$rating->recipe->slug}") }}">
                        <header class="w3-container w3-white w3-center" title="{{ $rating->recipe->name }}">
                            <h3>{{ FormatHelper::shorten($rating->recipe->name) }}</h3>
                        </header>

                        <div class="image">
                            <div class="w3-container w3-center w3-padding">
                                <img class="w3-round" src="{{ url("/images/recipes/{$rating->recipe->photo}") }}" alt="{{ "Rezept {$rating->recipe->name}" }}">
                            </div>
                        </div>

                        <p class="w3-container w3-white rating-stars">
                            @for ($i = 0; $i < $rating->stars; $i++)
                                <i class="star-on"></i>
                            @endfor
                        </p>

                        <p class="w3-container w3-white rating" title="{{ "{$rating->ratingCriterion->name}: {$rating->comment}" }}">
                            <strong>{{ $rating->ratingCriterion->name }}:</strong> {{ $rating->comment }}
                        </p>
                    </a>
                </article>
            @endforeach
        </div>
    @else
        <p>Keine Bewertungen vorhanden.</p>
    @endif

@endsection
