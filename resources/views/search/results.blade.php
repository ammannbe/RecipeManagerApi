@extends('layouts.master')


@section('title', 'Suchresultate')


@section('content-class', 'overview')
@section('content')

    <h2>Neusten Rezepte</h2>
    @foreach ($recipes as $recipe)
        <article>
            <a href="{{ url("/recipes/{$recipe->slug}") }}">
                @if ($recipe->photo)
                    <div class="image">
                        <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->photo }}">
                    </div>
                @endif

                <div class="instructions" title="{{ $recipe->instructions }}">
                    <h3>{{ $recipe->name }}</h3>
                    {!! nl2br(FormatHelper::shorten(preg_replace("/[\r\n]+/", "\n", $recipe->instructions), 200)) !!}
                </div>

                <div class="info">
                    @if ($recipe->category)
                        <small class="category">
                            <i class="fork-with-knife-and-plate"></i>
                            {{ $recipe->category->name }}
                        </small>
                    @endif

                    @if ($recipe->preparation_time)
                        <small class="hourglass">
                            {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}
                        </small>
                    @endif

                    <div class="rating">
                        @for ($i = 0; $i < $recipe->ratings->avg('stars'); $i++)
                            <small>
                                <i class="star-on"></i>
                            </small>
                        @endfor
                    </div>
                </div>
            </a>
        </article>
    @endforeach

@endsection
