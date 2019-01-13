@extends('layouts.master')


@section('title', 'Übersicht')


@section('class', 'overview')
@section('content')
    @foreach ($recipes as $recipe)
        <article>
            @if ($recipe->photo)
                <div class="image">
                    <a href="{{ url('/recipes/' . $recipe->id) }}">
                        <img src="{{ url('/images/recipes/'.$recipe->photo) }}">
                    </a>
                </div>
            @endif

            <div class="info">
                <strong><a href="{{ url('/recipes/' . $recipe->id) }}">{{ $recipe->name }}</a></strong>
                @foreach ($recipe->categories as $category)
                    <span>Kategorie: {{ $category->name }}</span><br>
                    @php break; @endphp
                @endforeach

                <span>Zubereitungszeit: {{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</span><br>
                <small>Erstellt: {{ FormatHelper::date($recipe->created_at) }}</small>
            </div>

            <div class="instructions" title="{{ $recipe->instructions }}">
                <strong style="display:block">Zubereitung:</strong>
                {!! nl2br(FormatHelper::shorten($recipe->instructions, 200)) !!}
            </div>

            @auth
                @if ($recipe->user_id == Auth::user()->id)
                    <div class="manage">
                        <a href="{{ url('recipes/edit/'.$recipe->id) }}"><i class="pencil black big"></i></a>
                        <a href="{{ url('recipes/delete/'.$recipe->id) }}"><i class="cross red big"></i></a>
                    </div>
                @endif
            @endauth

        </article>
    @endforeach
@endsection
