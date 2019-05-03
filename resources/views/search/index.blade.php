@extends('layouts.master')


@section('title', 'Rezeptsuche')
@section('meta-description', 'Einfach und schnell in über ' . (\App\Recipe::count() - rand(5, 10)) . ' Rezepten suchen.')


@section('content-class', 'search form')
@section('content')

    {{ Form::open(['url' => 'search', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('item', 'Suchen in') }}
            {{ Form::select('item', $tables, $default, [
                'class' => 'w3-input']) }}
        </p>

        <p>
            {{ Form::label('term', 'Suchbegriff', ['class' => 'required']) }}
            {{ Form::text('term', NULL, [
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: Kartoffel',
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right']) !!}
            {{ Form::button('Rezepte suchen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
