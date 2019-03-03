@extends('layouts.master')


@section('title', 'Profil')


@section('content-class', 'dashboard')
@section('content')
    <article class="profile">
        <h2>Details</h2>
        <div class="profile">
            <span>Name: {{ Auth::User()->name }}</span><br>
            <span>E-Mail: {{ Auth::User()->email }}</span><br>
            <a class="edit" href="/profile/edit">Profil bearbeiten<i class="pencil"></i></a>
        </div>
    </article>

    <article class="recipes">
        <h2>Deine Rezepte</h2>
        @foreach ($recipes as $recipe)
            @if (!isset($cookbookID) || $cookbookID != $recipe->cookbook->id)
                <h4>{{ $recipe->cookbook->name }}
                    @if ($recipe->cookbook->user_id == Auth::user()->id)
                        <a href="{{ url('/cookbooks/delete/'.$recipe->cookbook->id) }}"><i class="big red cross"></i></a>
                    @endif
                </h4>
            @endif
            @php($cookbookID = $recipe->cookbook->id)

            <li><a href="{{ url('/recipes/'.$recipe->id) }}">{{ $recipe->name }}</a></li>
        @endforeach
    </article>
@endsection
