@extends('layouts.master')


@section('title', 'Suchresultate')


@section('content-class', 'overview')
@section('content')

    <h2>Neusten Rezepte</h2>
    @foreach ($recipes as $recipe)
        <article>
            <a href="{{ url("/recipes/{$recipe->slug}") }}">
                <div class="image">
                    @if ($recipe->photo)
                        <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->name }}">
                    @else
                        <img src="{{ url('/images/placeholder.png') }}" alt="{{ $recipe->name }}">
                    @endif
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

@endsection
