@extends('layouts.master')


@section('title', 'Profil')


@section('content-class', 'dashboard')
@section('content')

    <article class="profile">
        <h2>Details</h2>
        <div>
            <span>Name: {{ Auth::User()->name }}</span><br>
            <span>E-Mail: {{ Auth::User()->email }}</span><br>
            <br>
            <a href="/profile/edit">Profil bearbeiten<i class="pencil"></i></a>
        </div>
    </article>

    <article class="recipes">
        <h2>Deine Rezepte</h2>
        <ul>
            @php($i = 0)
            @foreach ($recipes as $recipe)
            @php($i++)
                @if ($i >= 10)
                    <li class="forced hidden">
                @else
                    <li>
                @endif
                    <a href="{{ url("recipes/{$recipe->slug}") }}">{{ $recipe->name }}</a>
                </li>
            @endforeach
        </ul>
        {{ Form::button('Mehr anzeigen...', ['class' => 'show-more']) }}
    </article>
@endsection
