@extends('layouts.master')


@section('title', __('category.index.title'))


@section('content-class', 'category index')
@section('content')

    @auth
        @if (auth()->user()->is_admin)
            <div class="manage">
                <span class="w3-margin-right w3-margin-bottom hidden">{!! FormHelper::switch('edit-mode') !!}</span>
            </div>
        @endif
    @endauth

    <ul>
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>

                @auth
                    @if (auth()->user()->is_admin)
                        {{ Form::open(['url' => route('categories.destroy', $category->slug), 'class' => 'delete']) }}
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
