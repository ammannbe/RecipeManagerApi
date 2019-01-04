@extends('layouts.master')


@section('title', $recipe->name)


@section('class', 'recipe')
@section('content')

    @php
        $loggedIn = FALSE;
        $isRecipeOwner = FALSE;

        if (Auth::check()) {
            $loggedIn = TRUE;

            if (Auth::user()->id == $recipe->user_id) {
                $isRecipeOwner = TRUE;
            }
        }
    @endphp

    <article class="manage">
        <ul>
            @if ($loggedIn && $isRecipeOwner)
                {{-- <li><a href="{{ url('/recipes/edit/'.$recipe->id) }}"><i class="pencil black"></i>Bearbeiten</a></li> --}}
                <li>
                    <a href="{{ url('/recipes/delete/'.$recipe->id) }}" class="confirmation">
                        <i class="cross red"></i>
                        Löschen
                    </a>
                </li>
            @endif
            {{-- <li><a href="{{ url('/recipes/print/'.$recipe->id) }}">Drucken</a></li> --}}
        </ul>
    </article>

    @if ($recipe->photo)
        <article class="image">
            <img src="data:image/jpeg;base64,{{ base64_encode($recipe->photo) }}">
        </article>
    @endif

    <article class="info">
        <div>
            <h2>Kochbuch</h2>
            <span>{{ $recipe->cookbook->name }}</span>
        </div>
        <div>
            <h2>Autor</h2>
            <span>{{ $recipe->author->name }}</span>
        </div>
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
        <h2>Zutaten</h2>
        <ul>
            @foreach ($recipe->ingredientDetails as $ingredientDetail)
                @php
                    $ingredient = \App\Ingredient::find($ingredientDetail->ingredient_id);
                    $unit = \App\Unit::find($ingredientDetail->unit_id);
                @endphp

                <li>
                    @php
                        if ($ingredientDetail->prep_id) {
                            $prep = \App\Prep::find($ingredientDetail->prep_id);
                            $prepText = ', ' . $prep->name;
                        }
                    @endphp
                    {{ $ingredientDetail->amount }} {{ $unit->name_shortcut }} {{ $ingredient->name }}{{ $prepText }}
                    @if ($loggedIn && $isRecipeOwner)
                        <a href="/ingredients/delete/{{ $ingredientDetail->id }}"><i class="cross red"></i></a>
                    @endif
                </li>
            @endforeach
        </ul>
        @auth
            <a href="{{ url('/ingredients/add/' . $recipe->id) }}"><i class="plus-sign"></i>Zutat hinzufügen</a>
        @endauth
    </article>

    <article class="instructions">
        <h2>Zubereitung</h2>
        <ul>
            <li>Portionen: {{ $recipe->yield_amount }}</li>
            <li>Zubereitungszeit: {{ FormatHelper::time($recipe->preparation_time) }}</li>
        </ul>
        <p>
            {!! nl2br($recipe->instructions) !!}
        </p>
    </article>

    <article class="ratings">
        <h2>Bewertungen</h2>
        @php
            $class = '';
        @endphp

        @if ($loggedIn)
            @if (! \App\Rating::where('user_id', Auth::User()->id)
                ->where('recipe_id', $recipe->id)
                ->first())
                    <a href="{{ url('/ratings/add/' . $recipe->id) }}"><i class="plus-sign"></i>Bewertung hinzufügen</a>
                    <br><br>
            @endif
        @endif

        @foreach ($recipe->ratings as $rating)
            @php
                $user = \App\User::find($rating->user_id);
                $ratingOwner = FALSE;

                if ($loggedIn) {
                    if (\Auth::user()->id == $rating->user_id) {
                        $ratingOwner = TRUE;
                    }
                }
            @endphp

            <article class="{{ ($ratingOwner ? 'bg-grey' : '') }}">
                @if ($loggedIn && $ratingOwner)
                    <a href="{{ url('ratings/delete/'.$rating->id) }}" style="float:right;"><i class="cross red"></i>Löschen</a>
                @endif
                <strong>
                    {{ $rating->criterion->name }}
                </strong>
                <div>
                    {{ $rating->comment }}
                </div>
                <div>
                    <small>{{ FormatHelper::date($rating->created_at) }}, {{ $user->name }}</small>
                </div>
            </article>
        @endforeach
    </article>

@stop