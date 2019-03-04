@extends('layouts.master')


@section('title', 'Administration')


@section('content-class', 'administration')
@section('content')

    <ul>
        <li><a href="{{ url('/cookbooks/create') }}">Kochbuch erstellen</a></li>
        <li><a href="{{ url('/authors/create') }}">Autor erstellen</a></li>
        <li><a href="{{ url('/categories/create') }}">Kategorie erstellen</a></li>
        <li><a href="{{ url('/ingredients/create') }}">Zutat erstellen</a></li>
        <li><a href="{{ url('/units/create') }}">Einheit erstellen</a></li>
        <li><a href="{{ url('/preps/create') }}">Zutaten-Vorbereitung erstellen</a></li>
    </ul>

@stop
