@extends('layouts.master')


@section('title', 'Kategorie hinzufügen')


@section('content-class', 'category form')
@section('content')

    {{ Form::open(['url' => 'categories/create', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', 'Name') }}
            {{ Form::text('name', NULL, [
                'maxlength' => 50,
                'class'     => 'w3-input',
                'placeholder' => 'Bsp: Apéros',
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button('Kategorie hinzufügen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
