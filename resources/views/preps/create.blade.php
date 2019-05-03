@extends('layouts.master')


@section('title', 'Vorbereitung hinzufügen')


@section('content-class', 'prep form')
@section('content')

    {{ Form::open(['url' => 'preps/create', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', NULL, [
                'maxlength'   => 40,
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: gehackt',
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button('Vorbereitung hinzufügen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
