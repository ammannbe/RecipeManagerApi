@extends('layouts.master')


@section('title', $recipe->name)
@section('meta-description', "{$recipe->name}, Autor: {$recipe->author} Kategorie: {$recipe->category}")


@section('content-class', 'recipe')
@section('content')

    @php
        $isRecipeOwner = FALSE;

        if (auth()->check()) {
            if (auth()->user()->id == $recipe->user_id) {
                $isRecipeOwner = TRUE;
            } elseif (auth()->user()->isAdmin()) {
                $isRecipeOwner = TRUE;
            }
        }
    @endphp

    <article class="manage">
        <ul>
            @auth
                @if ($isRecipeOwner)
                    <li class="hidden"><span>Bearbeiten</span> {!! FormHelper::switch('edit-mode') !!}</li>
                    <li class="edit-mode item"><a href="{{ url("/recipes/edit/{$recipe->slug}") }}"><i class="pencil black"></i>Bearbeiten</a></li>
                    <li class="edit-mode item">
                        <a class="delete confirm" href="{{ url("/recipes/delete/{$recipe->slug}") }}">
                            <i class="cross red"></i>
                            Löschen
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </article>

    @if ($recipe->photo)
        <article class="image">
            <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ $recipe->photo }}">
        </article>
    @endif

    <article class="info">
        <h2>Details</h2>
        <table>
            @if ($recipe->author)
                <tr>
                    <th>Autor:</th>
                    <td>{{ $recipe->author->name }}</td>
                </tr>
            @endif
            @if ($recipe->category)
                <tr>
                    <th>Kategorie:</th>
                    <td>{{ $recipe->category->name }}</td>
                </tr>
            @endif
            @if ($recipe->yield_amount)
                <tr>
                    <th>Portionen:</th>
                    <td>{{ $recipe->yield_amount }}</td>
                </tr>
            @endif
            @if ($recipe->preparation_time)
                <tr>
                    <th>Zubereitungszeit:</th>
                    <td>{{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</td>
                </tr>
            @endif
        </table>
    </article>

    <article class="ingredients">
        <section class="list">
            <h2>Zutaten</h2>

            <ul>
                @foreach ($recipe->ingredientDetails as $ingredientDetail)
                    @php
                        if ($ingredientDetail->group) continue; // We show grouped ingredientDetails separately
                        if ($ingredientDetail->ingredient_detail_id) continue; // We show them as alternatives separately
                    @endphp

                    <li>
                        {{ $ingredientDetail->beautify() }}
                        @foreach ($ingredientDetail->ingredientDetail as $ingredientDetailAlternate)
                            <br>Oder: {{ $ingredientDetailAlternate->beautify() }}
                        @endforeach
                        @auth
                            @if ($isRecipeOwner)
                                <a class="edit-mode item delete confirm" href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
                            @endif
                        @endauth
                    </li>
                @endforeach

                @auth
                    @if ($isRecipeOwner)
                        <a class="edit-mode item" href="{{ url("/ingredient-details/create/{$recipe->slug}") }}">
                            Zutat hinzufügen
                        </a>
                    @endif
                @endauth
            </ul>
        </section>

        @if (isset($groups) && $groups)
            @foreach ($groups as $name => $group)
                <section class="list">
                    <h3>{{ $name }}</h3>
                    <ul>
                        @foreach ($group as $ingredientDetail)
                            <li>
                                {{ $ingredientDetail->beautify() }}
                                @foreach ($ingredientDetail->ingredientDetail as $ingredientDetailAlternate)
                                <br>Oder: {{ $ingredientDetailAlternate->beautify() }}
                                @endforeach
                                @auth
                                    @if ($isRecipeOwner)
                                        <a class="edit-mode item delete confirm" href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
                                    @endif
                                @endauth
                            </li>
                        @endforeach

                        @auth
                            @if ($isRecipeOwner)
                                <a class="edit-mode item" href="{{ url("/ingredient-details/create/{$recipe->slug}?group={$name}") }}">
                                    <i class="plus-sign"></i> Zutat hinzufügen
                                </a>
                            @endif
                        @endauth
                    </ul>
                </section>
            @endforeach
        @endif
    </article>

    <article class="instructions">
        <h2>Zubereitung</h2>
        <p>
            {!! nl2br(e($recipe->instructions)) !!}
        </p>
    </article>

    <article class="ratings">
        @auth
            @if (! \App\Rating::where([
                    'user_id'   => auth()->user()->id,
                    'recipe_id' => $recipe->id])->exists()
                )
                    <h2>Bewertungen</h2>
                    <a href="{{ url("ratings/add/{$recipe->slug}") }}">Bewertung hinzufügen</a>
            @else
                <h2>Bewertungen</h2>
            @endif
        @endauth

        @foreach ($recipe->ratings as $rating)
            @php $ratingOwner = FALSE; @endphp

            @auth
                @php
                    if (auth()->user()->id === $rating->user_id) {
                        $ratingOwner = TRUE;
                    } elseif (auth()->user()->isAdmin()) {
                        $ratingOwner = TRUE;
                    }
                @endphp
            @endauth

            <article class="{{ ($ratingOwner ? 'bg-grey' : '') }}">
                @auth
                    @if ($ratingOwner)
                        <div class="manage">
                            <a href="{{ url('ratings/edit/'.$rating->id) }}"><i class="pencil black big"></i></a>
                            <a class="delete confirm" href="{{ url('ratings/delete/'.$rating->id) }}"><i class="cross red big"></i></a>
                        </div>
                    @endif
                @endauth
                <strong>
                    {{ $rating->ratingCriterion->name }}
                </strong>
                <div>
                    {{ $rating->comment }}
                </div>
                <div>
                    <small>{{ $rating->user->name }}, {{ FormatHelper::date($rating->created_at) }}</small>
                </div>
                <div>
                    @for ($i = 0; $i < $rating->stars; $i++)
                        <img src="{{ asset('/images/star-on-big.png') }}" alt="Bewertungsstern">
                    @endfor
                </div>
            </article>
        @endforeach
    </article>

@stop
