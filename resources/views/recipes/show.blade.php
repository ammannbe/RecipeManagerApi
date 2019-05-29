@extends('layouts.master')

@php
    $author = '';
    if ($recipe->author) { $author = __('recipes.meta_author', ['author' => $recipe->author->name]); }
@endphp

@section('title', $recipe->name)
@section('meta-description', __('recipes.meta_description', [
    'name'     => $recipe->name,
    'author'   => $author,
    'category' => $recipe->category->name]))
@section('meta-image', url("/images/recipes/{$recipe->photo}"))


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
        <div class="w3-margin">
            @auth
                @if ($isRecipeOwner)
                    <span class="w3-margin-right w3-margin-bottom hidden">{!! FormHelper::switch('edit-mode') !!}</span>
                    <span class="w3-margin-right w3-margin-bottom">{{ __('recipes.edit') }}</span>
                    <span class="w3-margin-right w3-margin-bottom edit-mode item"><a href="{{ route('recipes.edit', $recipe->slug) }}"><i class="pencil black"></i>{{ __('recipes.edit') }}</a></span>
                    <span class="w3-margin-right w3-margin-bottom edit-mode item">
                        {{ Form::open(['url' => route('recipes.show', $recipe->slug), 'class' => 'delete']) }}
                            @method('DELETE')
                            <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                <i class="cross red middle"></i>{{ __('recipes.delete') }}
                            </button>
                        {{ Form::close() }}
                    </span>
                @endif
            @endauth
        </div>
    </article>

    <article class="header">
        @if ($recipe->photo)
            <div class="image">
                <div class="w3-card w3-center" onclick="Modal.photo(this)">
                    <img src="{{ url("/images/recipes/{$recipe->photo}") }}" alt="{{ __('recipes.recipe') }} {{ $recipe->photo }}">
                </div>
            </div>
        @endif

        <div class="details">
            <div class="w3-container">
                <ul>
                    @if ($recipe->author)
                        <li><strong>{{ __('recipes.author') }}</strong> {{ $recipe->author->name }}</li>
                    @endif
                    @if ($recipe->category)
                        <li><strong>{{ __('recipes.category') }}</strong> {{ $recipe->category->name }}</li>
                    @endif
                    @if ($recipe->yield_amount)
                        <li><strong>{{ __('recipes.yield_amount') }}</strong> {{ Form::number('yield_amount', $recipe->yield_amount, ['min' => 0, 'step' => 0.25]) }}</li>
                    @endif
                    @if ($recipe->preparation_time)
                        <li><strong>{{ __('recipes.preparation_time') }}</strong> {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</li>
                    @endif
                    @if ($recipe->tags->count())
                        <li>
                            <strong>{{ __('recipes.tags') }}</strong>
                            @foreach ($recipe->tags as $tag)
                                <span class="w3-padding-small w3-round w3-green">{{ $tag->name }}</span>
                            @endforeach
                        </li>
                    @endif
                    <li><br></li>
                    @if (count($recipe->ratings) > 0)
                        <li>
                            @for ($i = 0; $i < 5; $i++)
                                @if ($i < $recipe->ratings->avg('stars'))
                                    <small><i class="star-on"></i></small>
                                @else
                                    <small><i class="star-off"></i></small>
                                @endif
                            @endfor
                            <small class="count">({{ count($recipe->ratings) }})</small>
                        </li>
                    @endif
                    <li>
                        @if (auth()->check())
                            @if (! $recipe->ratings->where('user_id', auth()->user()->id)->first())
                                <a href="{{ route('recipes.ratings.create', $recipe->slug) }}">{{ __('recipes.add_rating') }}</a>
                            @endif
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </article>

    @if ($recipe->ingredientDetails->count())
        <article class="ingredients">
            <section class="list w3-card w3-padding">
                <div class="w3-row">
                    <div class="w3-col s12 m6 l3">
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
                                    <span data-current-amount="{{ $ingredientDetail->amount }}" data-amount="{{ $ingredientDetail->amount }}">
                                        {{ $ingredientDetail->beautify() }}
                                    </span>
                                    @foreach ($ingredientDetail->ingredientDetail as $ingredientDetailAlternate)
                                        <br>{{ __('recipes.or') }}
                                            <span data-current-amount="{{ $ingredientDetailAlternate->amount }}" data-amount="{{ $ingredientDetailAlternate->amount }}">
                                                {{ $ingredientDetailAlternate->beautify() }}
                                            </span>
                                    @endforeach
                                    @auth
                                        @if ($isRecipeOwner)
                                            {{ Form::open(['url' => "/recipes/{$recipe->slug}/ingredient-details/{$ingredientDetail->id}", 'class' => 'delete']) }}
                                                @method('DELETE')
                                                <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                                    <i class="cross red middle"></i>
                                                </button>
                                            {{ Form::close() }}
                                        @endif
                                    @endauth
                                </li>
                            @endforeach
                        </ul>

                        @auth
                            @if ($isRecipeOwner)
                                <a class="edit-mode item" href="{{ route('recipes.ingredient-details.create', $recipe->slug) }}">
                                    {{ __('recipes.add_ingredient') }}
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
                            <div class="w3-col s12 m6 l3 w3-margin-right">
                                <h3>{{ $name }}</h3>
                                <ul>
                                    @foreach ($group as $ingredientDetail)
                                        <li>
                                            <span data-current-amount="{{ $ingredientDetail->amount }}" data-amount="{{ $ingredientDetail->amount }}">
                                                {{ $ingredientDetail->beautify() }}
                                            </span>
                                            @foreach ($ingredientDetail->ingredientDetail as $ingredientDetailAlternate)
                                                <br>{{ __('recipes.or') }}
                                                    <span data-current-amount="{{ $ingredientDetailAlternate->amount }}" data-amount="{{ $ingredientDetailAlternate->amount }}">
                                                        {{ $ingredientDetailAlternate->beautify() }}
                                                    </span>
                                            @endforeach
                                            @auth
                                                @if ($isRecipeOwner)
                                                    {{ Form::open(['url' => "/recipes/{$recipe->slug}/ingredient-details", 'class' => 'delete']) }}
                                                        @method('DELETE')
                                                        <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                                            <i class="cross red middle"></i>
                                                        </button>
                                                    {{ Form::close() }}
                                                @endif
                                            @endauth
                                        </li>
                                    @endforeach
                                </ul>

                                @auth
                                    @if ($isRecipeOwner)
                                        <a class="edit-mode item" href="{{ route('recipes.ingredient-details.create', $recipe->slug, $name) }}">
                                            {{ __('recipes.add_ingredient') }}
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
    @else
        @auth
            @if ($isRecipeOwner)
                <br>
                <a class="edit-mode item" href="{{ route('recipes.ingredient-details.create', $recipe->slug) }}">
                    {{ __('recipes.add_ingredient') }}
                </a>
            @endif
        @endauth
    @endif

    <article class="instructions w3-card w3-padding">
        <h2>{{ __('recipes.preparation') }}</h2>
        <p>
            {!! nl2br(e($recipe->instructions)) !!}
        </p>
    </article>

    @if ($recipe->ratings->count())
        <article class="ratings w3-padding">
            @auth
                <h2>{{ __('recipes.rating') }}</h2>
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
                                <a href="{{ route('recipes.ratings.edit', [$recipe->slug, $rating->id]) }}" title="{{ __('forms.global.edit') }}"><i class="pencil black big"></i></a>

                                {{ Form::open(['url' => "/recipes/{$recipe->slug}/ratings/{$rating->id}", 'class' => 'delete']) }}
                                    @method('DELETE')
                                    <button class="item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                        <i class="cross red big"></i>
                                    </button>
                                {{ Form::close() }}
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
                            <img src="{{ asset('/images/star-on-big.png') }}" alt="{{ __('recipes.rating_star') }}">
                        @endfor
                    </div>
                </article>
            @endforeach
        </article>
    @endif
@stop
