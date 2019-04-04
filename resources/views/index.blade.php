@extends('layouts.master')


@section('title', 'Übersicht Rezepte')
@section('meta-description',
        'Weisst du nicht, was du heute Kochen sollst? ' .
        'Finde hier die besten Rezepte unter den ' . \App\Recipe::count() . ' aufgeführten Rezepten. ' .
        'Immer frisch. Immer aktuell. Immer gut.'
    )


@section('content-class', 'overview')
@section('content')

    <h2>Neusten Rezepte</h2>
    @foreach ($newRecipes as $recipe)
        <article>
            <a href="{{ url("/recipes/{$recipe->slug}") }}">
                <div class="image">
                    <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->photo }}">
                </div>

                <div class="instructions" title="{{ $recipe->instructions }}">
                    <h3>{{ $recipe->name }}</h3>
                    {!! nl2br(FormatHelper::shorten(preg_replace("/[\r\n]+/", "\n", $recipe->instructions), 200)) !!}
                </div>

                <div class="info">
                    @if ($recipe->preparation_time)
                        <small>
                            {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}
                        </small>
                    @endif

                    <div class="recipe-rating">
                        @if (count($recipe->ratings) > 0)
                            @for ($i = 0; $i < $recipe->ratings->avg('stars'); $i++)
                                <small>
                                    <i class="star-on"></i>
                                </small>
                            @endfor
                            <small class="count">({{ count($recipe->ratings) }})</small>
                        @endif
                    </div>
                </div>
            </a>
        </article>
    @endforeach

    <h2>Beliebteste Rezepte</h2>
    @foreach ($topRecipes as $recipe)
        <article>
            <a href="{{ url("/recipes/{$recipe->slug}") }}">
                <div class="image">
                    <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->photo }}">
                </div>

                <div class="instructions" title="{{ $recipe->instructions }}">
                    <h3>{{ $recipe->name }}</h3>
                    {!! nl2br(FormatHelper::shorten(preg_replace("/[\r\n]+/", "\n", $recipe->instructions), 200)) !!}
                </div>

                <div class="info">
                    @if ($recipe->preparation_time)
                        <small>
                            {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}
                        </small>
                    @endif

                    <div class="recipe-rating">
                        @if (count($recipe->ratings) > 0)
                            @for ($i = 0; $i < $recipe->ratings->avg('stars'); $i++)
                                <small>
                                    <i class="star-on"></i>
                                </small>
                            @endfor
                            <small class="count">({{ count($recipe->ratings) }})</small>
                        @endif
                    </div>
                </div>
            </a>
        </article>
    @endforeach

    <h2>Neuste Bewertungen</h2>
    @foreach ($ratings as $rating)
        <article class="new-ratings">
            <a href="{{ url("/recipes/{$rating->recipe->slug}") }}">
                <div class="image">
                    <img src="{{ url("/images/recipes/{$rating->recipe->photo}") }}" alt="{{ $rating->recipe->photo }}">
                </div>

                <div class="rating">
                    <h3>{{ $rating->recipe->name }}</h3>
                    @for ($i = 0; $i < $rating->stars; $i++)
                        <i class="star-on"></i>
                    @endfor

                    <p><strong>{{ $rating->ratingCriterion->name }}:</strong> {{ $rating->comment }}</p>
                </div>
            </a>
        </article>
    @endforeach

@endsection
