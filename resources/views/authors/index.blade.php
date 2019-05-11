@extends('layouts.master')


@section('title', __('author.index.title'))


@section('content-class', 'author index')
@section('content')

    <ul>
        @foreach ($authors as $author)
            <li>
                <a href="{{ route('authors.show', $author->slug) }}">{{ $author->name }}</a>

                @if (auth()->user() && auth()->user()->isAdmin())
                    {{ Form::open(['url' => route('authors.destroy', $author->slug), 'class' => 'delete']) }}
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
