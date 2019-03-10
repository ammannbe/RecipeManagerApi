@extends('layouts.master')


@section('title', 'Profil')


@section('content-class', 'dashboard')
@section('content')

    @auth
        <article class="manage">
            Bearbeiten {!! FormHelper::switch('edit-mode switch') !!}
        </article>
    @endauth

    <article class="profile">
        <h2>Details</h2>
        <div class="profile">
            <span>Name: {{ Auth::User()->name }}</span><br>
            <span>E-Mail: {{ Auth::User()->email }}</span><br>
            <a class="edit edit-mode item hidden" href="/profile/edit">Profil bearbeiten<i class="pencil"></i></a>
        </div>
    </article>

    <article class="recipes">
        <h2>Deine Rezepte</h2>
        <ul>
            @php($i = 0)
            @foreach ($recipes as $recipe)
                @php($i++)
                @if (!isset($cookbookID) || $cookbookID != $recipe->cookbook->id)
                    <h4>{{ $recipe->cookbook->name }}
                        @if ($recipe->cookbook->user_id == Auth::user()->id)
                            <a class="edit-mode item hidden delete confirm" href="{{ url('/cookbooks/delete/'.$recipe->cookbook->id) }}"><i class="big red cross"></i></a>
                        @endif
                    </h4>
                @endif
                @php($cookbookID = $recipe->cookbook->id)

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
