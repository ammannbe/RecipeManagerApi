@extends('layouts.master')


@section('title', __('author.index.title'))


@section('content-class', 'author index')
@section('content')

    @auth
        @if (auth()->user()->is_admin)
            <div class="manage">
                <span class="w3-margin-right w3-margin-bottom hidden">{!! FormHelper::switch('edit-mode') !!}</span>
            </div>
        @endif
    @endauth

    <ul>
        @foreach ($authors as $author)
            <li>
                <a href="{{ route('authors.show', $author->slug) }}">{{ $author->name }}</a>

                @auth
                    @if (auth()->user()->is_admin)
                        {{ Form::open(['url' => route('authors.destroy', $author->slug), 'class' => 'delete']) }}
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

@stop
