@extends('layouts.master')


@section('title', 'Profil bearbeiten')


@section('content-class', 'user-form')
@section('content')
    {{ Form::open(['url' => 'profile/edit', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {!! Form::label('name', 'Name',
                ['class' => 'required']) !!}
            {!! Form::text('name', $user->name, [
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required', 'autofocus']) !!}
        </p>

        <p>
            {!! Form::label('email', 'E-Mail', ['class' => 'required']) !!}
            {!! Form::email('email', $user->email, [
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required']) !!}
        </p>

        <p>
            {!! Form::label('current_password', 'Aktuelles Passwort') !!}
            {!! Form::password('current_password', [
                'maxlength' => 255,
                'class'     => 'w3-input']) !!}
            <small>(Leer lassen um nicht zu ändern)</small>
        </p>

        <p>
            {!! Form::label('new_password', 'Neues Passwort') !!}
            {!! Form::password('new_password', [
                'maxlength' => 255,
                'class'     => 'w3-input']) !!}
        </p>

        <p>
            {!! Form::label('new_password_confirmation', 'Passwort bestätigen') !!}
            {!! Form::password('new_password_confirmation', [
                    'maxlength' => 255,
                    'class'     => 'w3-input']) !!}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/profile') !!}
            {{ Form::button('Änderungen speichern', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {!! Form::close() !!}
@stop
