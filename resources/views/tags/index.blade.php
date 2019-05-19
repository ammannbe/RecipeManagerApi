@extends('layouts.master')


@section('title', __('tag.index.title'))


@section('content-class', 'tag index')
@section('content')

    @auth
        @if (auth()->user()->isAdmin())
            <div class="manage">
                <span class="w3-margin-right w3-margin-bottom hidden">{!! FormHelper::switch('edit-mode') !!}</span>
            </div>
        @endif
    @endauth

    <ul>
        @foreach ($tags as $tag)
            <li>
                <a href="{{ route('tags.show', $tag->slug) }}">{{ $tag->name }}</a>

                @if (auth()->user() && auth()->user()->isAdmin())
                    {{ Form::open(['url' => route('tags.destroy', $tag->slug), 'class' => 'delete']) }}
                        @method('DELETE')
                        <button class="edit-mode item delete confirm" data-confirm="{{ __('forms.global.confirm') }}">
                            <i class="cross red middle"></i>
                        </button>
                    {{ Form::close() }}
                @endif
            </li>
        @endforeach
    </ul>

@stop
