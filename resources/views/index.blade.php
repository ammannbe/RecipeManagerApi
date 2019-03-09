@extends('layouts.master')


@section('title', 'Übersicht')


@section('content-class', 'overview')
@section('content')

    @foreach ($recipes as $recipe)
        <article>
            <a href="{{ url('/recipes/' . $recipe->id) }}">

                @if ($recipe->photo)
                    <div class="image">
                        <img src="{{ url('/images/recipes/'.$recipe->photo) }}">
                    </div>
                @endif

                <div class="info">
                    <strong>{{ $recipe->name }}</strong>
                    @if ($recipe->category)
                        <i class="fork-with-knife-and-plate"></i>
                        <span>{{ $recipe->category->name }}</span><br>
                    @endif

                    @if ($recipe->preparation_time)
                        <small class="hourglass">{{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</small><br>
                    @endif
                    @if ($recipe->author)
                        <small><i class="bust"></i>{{ $recipe->author->name }}</small><br>
                    @endif
                    <small><i class="hammer-and-wrench"></i>Erstellt: {{ FormatHelper::date($recipe->created_at) }}</small>
                </div>

                <div class="instructions" title="{{ $recipe->instructions }}">
                    <strong style="display:block">Zubereitung:</strong>
                    {!! nl2br(FormatHelper::shorten($recipe->instructions, 200)) !!}
                </div>
            </a>

        </article>
    @endforeach

    @if (!is_array($recipes))
        {{ $recipes->links() }}
    @endif

@endsection
