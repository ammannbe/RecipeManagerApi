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

    <article>
        @if ($recipe->photo)
            <div class="image">
                <div class="w3-card w3-center">
                    <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="Rezept {{ $recipe->photo }}">
                </div>
            </div>
        @endif

        {{-- TODO: Bewertung hier rein --}}
        {{-- @if (auth()->check())
            @if ($recipe->ratings->where('user_id', auth()->user()->id))
                <a href="{{ url("ratings/add/{$recipe->slug}") }}">Bewertung hinzufügen</a>
            @endif
        @endif --}}

        <div class="details">
            <div class="w3-container">
                <ul>
                    @if ($recipe->author)
                        <li><strong>Autor:</strong> {{ $recipe->author->name }}</li>
                    @endif
                    @if ($recipe->category)
                        <li><strong>Kategorie:</strong> {{ $recipe->category->name }}</li>
                    @endif
                    @if ($recipe->yield_amount)
                        <li><strong>Portionen:</strong> {{ $recipe->yield_amount }}</li>
                    @endif
                    @if ($recipe->preparation_time)
                        <li><strong>Zubereitungszeit:</strong> {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</li>
                    @endif
                </ul>
            </div>
        </div>
    </article>

    @if ($recipe->ingredientDetails->count())
        <article class="ingredients">
            <section class="list w3-card">
                <div class="w3-row">
                    <div class="w3-col s12 m6 l3 w3-padding">
                        <h2>Zutaten</h2>

                        <ul>
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($recipe->ingredientDetails as $ingredientDetail)
                                @php
                                    if ($ingredientDetail->group) continue; // We show grouped ingredientDetails separately
                                    if ($ingredientDetail->ingredient_detail_id) continue; // We show them as alternatives separately
                                    $i = 1;
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
                        </ul>

                        @auth
                            @if ($isRecipeOwner)
                                <a class="edit-mode item" href="{{ url("/ingredient-details/create/{$recipe->slug}") }}">
                                    Zutat hinzufügen
                                </a>
                            @endif
                        @endauth
                    </div>

                    @if (isset($groups) && $groups)
                        @foreach ($groups as $name => $group)
                            @php
                                $i++;
                            @endphp

                            @if ($i % 4 == 1)
                                </div>
                                <div class="w3-row">
                            @endif
                            <div class="w3-col s12 m6 l3 w3-padding">
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
                                </ul>

                                @auth
                                    @if ($isRecipeOwner)
                                        <a class="edit-mode item" href="{{ url("/ingredient-details/create/{$recipe->slug}?group={$name}") }}">
                                            <i class="plus-sign"></i> Zutat hinzufügen
                                        </a>
                                    @endif
                                @endauth
                            </div>
                            @if ($i % 4 == 0)
                                </div>
                            @endif
                        @endforeach
                    @endif
                </div>
            </section>
        </article>
    @endif

    <article class="instructions w3-card w3-padding">
        <h2>Zubereitung</h2>
        <p>
            {!! nl2br(e($recipe->instructions)) !!}
        </p>
    </article>

    @if ($recipe->ratings->count())
        <article class="ratings w3-padding">
            @auth
                <h2>Bewertungen</h2>
            @endauth

            @php
                $j = 0;
            @endphp
            @foreach ($recipe->ratings as $rating)

                @php
                    $j++;
                    if ($j > 5) { continue; }
                    $ratingOwner = FALSE;
                @endphp

                @auth
                    @php
                        if (auth()->user()->id === $rating->user_id) {
                            $ratingOwner = TRUE;
                        } elseif (auth()->user()->isAdmin()) {
                            $ratingOwner = TRUE;
                        }
                    @endphp
                @endauth

                <article class="rating w3-panel w3-border w3-padding {{ ($ratingOwner ? 'bg-grey' : '') }}">
                    @auth
                        @if ($ratingOwner)
                            <div class="manage">
                                <a href="{{ url('ratings/edit/'.$rating->id) }}" title="Bearbeiten"><i class="pencil black big"></i></a>
                                <a href="{{ url('ratings/delete/'.$rating->id) }}" title="Löschen" class="delete confirm" ><i class="cross red big"></i></a>
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
    @endif
@stop
