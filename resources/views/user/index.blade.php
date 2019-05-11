@extends('layouts.master')


@section('title', __('user.index.title'))


@section('content-class', 'dashboard')
@section('content')

    <article class="profile">
        <h2>{{ __('user.index.details') }}</h2>
        <div>
            <span>{{ __('user.index.name') }} {{ Auth::User()->name }}</span><br>
            <span>{{ __('user.index.email') }} {{ Auth::User()->email }}</span><br>
            <br>
            <a href="{{ route('user.edit') }}">{{ __('user.index.edit_profile') }}<i class="pencil"></i></a>
        </div>
    </article>

    <article class="recipes">
        <h2>{{ __('user.index.your_recipes') }}</h2>
        <ul>
            @php($i = 0)
            @foreach ($recipes as $recipe)
            @php($i++)
                @if ($i >= 10)
                    <li class="forced hidden">
                @else
                    <li>
                @endif
                    <a href="{{ route('recipes.show', $recipe->slug) }}">{{ $recipe->name }}</a>
                </li>
            @endforeach
        </ul>
        {{ Form::button( __('user.index.show_more') , ['class' => 'show-more']) }}
    </article>
@endsection
