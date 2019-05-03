@extends('layouts.master')


@section('title', 'Suchresultate')


@section('content-class', 'search-results')
@section('content')

    @foreach ($recipes as $recipe)
        <article class="w3-animate-zoom w3-col w3-container w3-hover-shadow w3-card w3-margin-bottom w3-padding">
            <a href="{{ url("/recipes/{$recipe->slug}") }}">
                <div class="image">
                    <div class="w3-container w3-left w3-padding">
                        @if ($recipe->photo)
                            <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->name }}">
                        @else
                            <img src="{{ url('/images/placeholder.png') }}" alt="{{ $recipe->name }}">
                        @endif
                    </div>
                </div>

                <div class="instructions" title="{{ $recipe->instructions }}">
                    <h3>{{ $recipe->name }}</h3>
                    {{ $recipe->instructions }}
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

@endsection
