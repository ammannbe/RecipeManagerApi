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
                    @foreach ($recipe->categories as $category)
                        <span>{{ $category->name }}</span><br>
                        @php break; @endphp
                    @endforeach

                        @if ($recipe->preparation_time)
                            <small class="hourglass">{{ FormatHelper::time($recipe->preparation_time, ['hours', 'minutes']) }}</small><br>
                        @endif
                    <small>Erstellt: {{ FormatHelper::date($recipe->created_at) }}</small>
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
