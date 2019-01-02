@extends('layouts.master')


@section('title', $recipe->name)


@section('class', 'recipe')
@section('content')

    <article class="manage">
        <ul>
            @if (Auth::check())
                {{-- <li><a href="{{ url('/recipes/edit/'.$recipe->id) }}"><i class="pencil black"></i>Bearbeiten</a></li> --}}
                <li><a href="{{ url('/recipes/delete/'.$recipe->id) }}"><i class="cross red"></i>Löschen</a></li>
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
                @php ($ingredient = \App\Ingredient::find($ingredientDetail->ingredient_id))
                @php ($unit = \App\Unit::find($ingredientDetail->unit_id))

                <li>
                    @if ($ingredientDetail->prep_id)
                        @php ($prep = \App\Prep::find($ingredientDetail->prep_id))
                        @php ($prepText = ', ' . $prep->name)
                    @endif
                    {{ $ingredientDetail->amount }} {{ $unit->name_shortcut }} {{ $ingredient->name }}{{ $prepText }}
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
        @if (Auth::check())
            @if (! \App\Rating::where('user_id', Auth::User()->id)
                ->where('recipe_id', $recipe->id)
                ->first())
                    <a href="{{ url('/ratings/add/' . $recipe->id) }}"><i class="plus-sign"></i>Bewertung hinzufügen</a>
                    <br><br>
            @endif
        @endif

        @foreach ($recipe->ratings as $rating)
            @php ($user = \App\User::find($rating->user_id))

            <article>
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
