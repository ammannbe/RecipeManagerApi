@extends('layouts.master')


@section('title', $recipe->name)


@section('class', 'recipe')
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
        <h2>
            Zutaten
            @auth
                <a href="{{ url('/ingredients/add/' . $recipe->id) }}"><i class="plus-sign"></i></a>
            @endauth
        </h2>
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
                    @auth
                        @if ($isRecipeOwner)
                            <a href="/ingredients/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
                        @endif
                    @endauth
                </li>
            @endforeach
        </ul>
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

        @php
            $class = ''
        @endphp

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
                        <a href="{{ url('ratings/delete/'.$rating->id) }}" class="delete"><i class="cross red big"></i></a>
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