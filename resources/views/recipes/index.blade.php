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
        @auth
            @if ($isRecipeOwner)
                Verwaltung {!! FormHelper::switch('edit-mode switch') !!}
            @endif
        @endauth

        <ul>
            @auth
                @if ($isRecipeOwner)
                    <li class="edit-mode item hidden"><a href="{{ url('/recipes/edit/'.$recipe->id) }}"><i class="pencil black"></i>Bearbeiten</a></li>
                    <li class="edit-mode item hidden">
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
        <h2>Details</h2>
        <table>
            @if ($recipe->cookbook)
                <tr>
                    <th>Kochbuch:</th>
                    <td>{{ $recipe->cookbook->name }}</td>
                </tr>
            @endif
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
            <h2>
                Zutaten
                @auth
                    @if ($isRecipeOwner)
                        <a class="edit-mode item hidden" href="{{ url('/ingredient-details/create/' . $recipe->id) }}"><i class="plus-sign"></i></a>
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
                                <a class="edit-mode item hidden" href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
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
                                        <a class="edit-mode item hidden" href="/ingredient-details/delete/{{ $ingredientDetail->id }}"><i class="cross red big"></i></a>
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
