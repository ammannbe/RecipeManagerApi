@extends('layouts.master')


@section('title', 'Einheit hinzufügen')


@section('content-class', 'unit form')
@section('content')

    {{ Form::open(['url' => 'units/create', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', 'Name (Singular)', ['class' => 'required']) }}
            {{ Form::text('name', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: Flasche',
                'required', 'autofocus']) }}
        </p>

        <p>
            {{ Form::label('name_shortcut', 'Abkürzung (Singular)') }}
            {{ Form::text('name_shortcut', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: Fl.']) }}
        </p>

        <p>
            {{ Form::label('name_plural', 'Name (Plural)') }}
            {{ Form::text('name_plural', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: Flaschen']) }}
        </p>

        <p>
            {{ Form::label('name_plural_shortcut', 'Abkürzung (Plural)') }}
            {{ Form::text('name_plural_shortcut', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => 'Bsp: Fl.']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button('Einheit hinzufügen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
