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
                    <div class="edit">
                        <span class="w3-margin-right w3-margin-bottom hidden">{!! FormHelper::switch('edit-mode') !!}</span>
                        <span class="w3-margin-right w3-margin-bottom">{{ __('recipes.edit-mode') }}</span>
                        <span class="w3-margin-right w3-margin-bottom edit-mode item">
                            {{ Form::open(['url' => route('recipes.show', $recipe->slug), 'class' => 'delete']) }}
                                @method('DELETE')
                                <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                    <i class="cross red middle"></i>{{ __('recipes.delete') }}
                                </button>
                            {{ Form::close() }}
                        </span>
                    </div>
                @endif
            @endauth
            <div class="share-widget w3-right w3-margin-right w3-margin-bottom w3-border" style="display: none;">
                {{-- Telegram --}}
                <a href="//telegram.me/share/url?url={{ url()->current() }}&text={{ $recipe->name }}" target="_blank" title="{{ __('share.telegram') }}">
                    <img src="{{ url('/images/icons/telegram.svg') }}" width="60" height="60" alt="Telegram">
                </a>
                {{-- E-Mail --}}
                <a href="mailto:?Subject={{ $recipe->name }}&amp;Body=@yield('meta-description') {{ url()->current() }}" title="{{ __('share.email') }}">
                    <img src="https://simplesharebuttons.com/images/somacro/email.png" width="48" height="48" alt="E-Mail">
                </a>
                {{-- Print --}}
                <a href="javascript:;" onclick="window.print()" title="{{ __('share.print') }}">
                    <img src="https://simplesharebuttons.com/images/somacro/print.png" width="48" height="48" alt="Print">
                </a>
                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer.php?u={{ url()->current() }}" target="_blank" title="{{ __('share.facebook') }}">
                    <img src="https://simplesharebuttons.com/images/somacro/facebook.png" width="48" height="48" alt="Facebook">
                </a>

                <button class="hide">
                    <i class="cross red middle"></i>
                </button>
            </div>
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
                        <li><strong>{{ __('recipes.yield_amount') }}</strong> {{ Form::number('yield_amount', $recipe->yield_amount, ['autocomplete' => 'off', 'min' => 0, 'step' => 0.25]) }}</li>
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
                    <span class="w3-margin-right w3-margin-bottom edit-mode item"><a href="{{ route('recipes.edit', $recipe->slug) }}"><i class="pencil black"></i>{{ __('recipes.edit') }}</a></span>
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
                                <a href="{{ route('recipes.ratings.create', $recipe->slug) }}"><i class="plus-sign middle"></i>{{ __('recipes.add_rating') }}</a>
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
                                    @foreach ($ingredientDetail->ingredientDetail as $alternate)
                                        <br>{{ __('recipes.or') }}
                                            <span data-current-amount="{{ $alternate->amount }}" data-amount="{{ $alternate->amount }}">
                                                {{ $alternate->beautify() }}
                                            </span>
                                    @endforeach
                                    @auth
                                        @if ($isRecipeOwner)
                                            <a class="edit-mode item" href="{{ route('recipes.ingredient-details.edit', [$recipe->slug, $ingredientDetail->id]) }}"><i class="pencil middle"></i></a>
                                            {{ Form::open(['url' => route('recipes.ingredient-details.destroy', [$recipe->slug, $ingredientDetail->id]), 'class' => 'delete']) }}
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
                                <br>
                                <a class="edit-mode item" href="{{ route('recipes.ingredient-detail-groups.create', $recipe->slug) }}">
                                    {{ __('recipes.add_ingredient_detail_group') }}
                                </a>
                            @endif
                        @endauth
                    </div>

                    @if (isset($groups) && $groups)
                        @foreach ($groups as $group)
                            @php
                                $i++;
                            @endphp

                            @if ($i % 4 == 1)
                                </div>
                                <div class="w3-row">
                            @endif
                            <div class="w3-col s12 m6 l3 w3-margin-right ingredient-group">
                                <h3>{{ $group['model']->name }}</h3>
                                @if ($isRecipeOwner)
                                    <a class="edit-mode item" href="{{ route('recipes.ingredient-detail-groups.edit', [$recipe->slug, $group['model']->id]) }}"><i class="pencil middle"></i></a>
                                    {{ Form::open(['url' => route('recipes.ingredient-detail-groups.destroy', [$recipe->slug, $group['model']->id]), 'class' => 'delete']) }}
                                        @method('DELETE')
                                        <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                                            <i class="cross red middle"></i>
                                        </button>
                                    {{ Form::close() }}
                                @endif
                                <ul>
                                    @foreach ($group['ingredients'] as $ingredientDetail)
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
                                                    <a class="edit-mode item" href="{{ route('recipes.ingredient-details.edit', [$recipe->slug, $ingredientDetail->id]) }}"><i class="pencil middle"></i></a>
                                                    {{ Form::open(['url' => route('recipes.ingredient-details.destroy', [$recipe->slug, $ingredientDetail->id]), 'class' => 'delete']) }}
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
                                        <a class="edit-mode item" href="{{ route('recipes.ingredient-details.create', $recipe->slug) }}?group={{ $group['model']->name }}">
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
        <span class="w3-margin-right w3-margin-bottom edit-mode item"><a href="{{ route('recipes.edit', $recipe->slug) }}"><i class="pencil black"></i>{{ __('recipes.edit') }}</a></span>
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
