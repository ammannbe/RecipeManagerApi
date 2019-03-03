@extends('layouts.master')


@section('title', $recipe->name)


@section('content-class', 'recipe')
@section('content')

    @php
        $isRecipeOwner = FALSE;

        if (Auth::check()) {
            if (Auth::user()->id == $recipe->user_id) {
                $isRecipeOwner = TRUE;
            }
        }
    @endphp

    <article class="manage">
        <ul>
            @auth
                @if ($isRecipeOwner)
                    <li><a href="{{ url('/recipes/edit/'.$recipe->id) }}"><i class="pencil black"></i>Bearbeiten</a></li>
                    <li>
                        <a href="{{ url('/recipes/delete/'.$recipe->id) }}">
                            <i class="cross red"></i>
                            Löschen
                        </a>
                    </li>
                @endif
            @endauth
            {{-- <li><a href="{{ url('/recipes/print/'.$recipe->id) }}">Drucken</a></li> --}}
        </ul>
    </article>

    @if ($recipe->photo)
        <article class="image">
            <img src="{{ url('/images/recipes/'.$recipe->photo) }}">
        </article>
    @endif

    <article class="info">
        <div>
            <h2>Kochbuch</h2>
            <span>{{ $recipe->cookbook->name }}</span>
        </div>
        @if (isset($recipe->author->name))
            <div>
                <h2>Autor</h2>
                <span>{{ $recipe->author->name }}</span>
            </div>
        @endif
        <div>
            <h2>Kategorien</h2>
            <ul>
                @foreach ($recipe->categories as $category)
                    <li>{{ $category->name }}</li>
                @endforeach
            </ul>
        </div>
    </article>

    <article class="ingredients">
        <section class="list">
            <h2>
                Zutaten
                @auth
                    @if ($isRecipeOwner)
                        <a href="{{ url('/ingredient-details/create/' . $recipe->id) }}"><i class="plus-sign"></i></a>
                    @endif
                @endauth
            </h2>

            <ul>
                @foreach ($recipe->ingredientDetails as $ingredientDetail)
                    @php
                        if ($ingredientDetail->group) continue;
                        if ($ingredientDetail->ingredient_detail_id) continue;
                    @endphp

                    <li>
                        {{ $ingredientDetail->display }}
                        @if ($ingredientDetail->alternate)
                            <i class="question-mark" title="Oder {{ $ingredientDetail->alternate->display }}"></i>
                        @endif
                        @auth
                            @if ($isRecipeOwner)
                                <a href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
                            @endif
                        @endauth
                    </li>
                @endforeach
            </ul>
        </section>

        @if (isset($ingredientDetailGroups) && $ingredientDetailGroups)
            @foreach ($ingredientDetailGroups as $name => $group)
                <section class="list">
                    <h3>{{ $name }}</h3>
                    <ul>
                        @foreach ($group as $ingredientDetail)
                            @php
                                if ($ingredientDetail->ingredient_detail_id) continue;
                            @endphp

                            <li>
                                {{ $ingredientDetail->display }}
                                @if ($ingredientDetail->alternate)
                                    <i class="question-mark" title="Oder {{ $ingredientDetail->alternate->display }}"></i>
                                @endif
                                @auth
                                    @if ($isRecipeOwner)
                                        <a href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
                                    @endif
                                @endauth
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endforeach
        @endif
    </article>

    <article class="instructions">
        <h2>Zubereitung</h2>
        <ul>
            @php
                if ($recipe->yield_amount_max) {
                    $recipe->yield_amount_text = "{$recipe->yield_amount} - {$recipe->yield_amount_max}";
                } else {
                    $recipe->yield_amount_text = "{$recipe->yield_amount}";
                }
            @endphp
            <li>Portionen: {{ $recipe->yield_amount_text }}</li>
            <li>Zubereitungszeit: {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</li>
        </ul>
        <p>
                {!! nl2br(e($recipe->instructions)) !!}
        </p>
    </article>

    <article class="ratings">
        @auth
            @if (! \App\Rating::where('user_id', Auth::User()->id)
                ->where('recipe_id', $recipe->id)
                ->first())
                    <h2>
                        Bewertungen
                        <a href="{{ url('/ratings/add/' . $recipe->id) }}"><i class="plus-sign"></i></a>
                    </h2>
            @else
                <h2>Bewertungen</h2>
            @endif
        @endauth

        @foreach ($recipe->ratings as $rating)
            @php
                $user = \App\User::find($rating->user_id);
                $ratingOwner = FALSE;
            @endphp

            @auth
                @php
                    if (\Auth::user()->id == $rating->user_id) {
                        $ratingOwner = TRUE;
                    }
                @endphp
            @endauth

            <article class="{{ ($ratingOwner ? 'bg-grey' : '') }}">
                @auth
                    @if ($ratingOwner)
                        <div class="manage">
                            <a href="{{ url('ratings/edit/'.$rating->id) }}"><i class="pencil black big"></i></a>
                            <a href="{{ url('ratings/delete/'.$rating->id) }}"><i class="cross red big"></i></a>
                        </div>
                    @endif
                @endauth
                <strong>
                    {{ $rating->criterion->name }}
                </strong>
                <div>
                    {{ $rating->comment }}
                </div>
                <div>
                    <small>{{ $user->name }}, {{ FormatHelper::date($rating->created_at) }}</small>
                </div>
            </article>
        @endforeach
    </article>

@stop
