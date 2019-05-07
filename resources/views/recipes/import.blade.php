@extends('layouts.master')


@section('title', 'Rezept importieren')


@section('content-class', 'import form')
@section('content')

    {{ Form::open(['url' => 'recipes/import', 'enctype="multipart/form-data"', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('file', 'Rezept (*.kreml)') }}
            {{ Form::file('file', ['class' => 'w3-input']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen',
                ['class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button('Rezept importieren', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {!! Form::close() !!}

@stop
