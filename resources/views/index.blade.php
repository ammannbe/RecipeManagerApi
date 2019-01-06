@extends('layouts.master')


@section('title', 'Übersicht')


@section('class', 'overview')
@section('content')
    @foreach ($recipes as $recipe)
        <article>
            @if ($recipe->photo)
                <div class="image">
                    <a href="{{ url('/recipes/' . $recipe->id) }}">
                        <img src="data:image/jpeg;base64,{{ base64_encode($recipe->photo) }}">
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

            <div class="instructions">
                {!! nl2br(FormatHelper::shorten($recipe->instructions, 200)) !!}
            </div>
        </article>
    @endforeach
@endsection
