@extends('layouts.master')


@section('title', __('author.show.title', ['author' => $author->name]))


@section('content-class', 'overview')
@section('content')

    <div class="w3-row">
        @php
            $i = 0;
            $class = '';
            $count = count($recipes)
        @endphp
        @foreach ($recipes as $recipe)
            @php
                $i++;
                if ($i >= 3)  { $class = 'w3-hide-medium'; }
                if ($count <= 2) { $class .= ' l4'; }
                else { $class .= ' l3'; }
            @endphp
            <article class="w3-col w3-container w3-hover-shadow w3-card s12 m6 {{ $class }}">
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
    </div>

@stop
