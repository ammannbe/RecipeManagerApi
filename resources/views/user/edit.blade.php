@extends('layouts.master')


@section('title', 'Profil bearbeiten')


@section('content-class', 'user form')
@section('content')
    {!! Form::open(['url' => 'profile/edit']) !!}
        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', $user->name, ['maxlength' => 255, 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::label('E-Mail', NULL, ['class' => 'required']) !!}
                {!! Form::email('email', $user->email, ['maxlength' => 255, 'required']) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Aktuelles Passwort') !!}
                {!! Form::password('current_password', NULL, ['maxlength' => 255]) !!}
                <small>(Leer lassen um nicht zu ändern)</small>
            </div>

            <div>
                {!! Form::label('Neues Passwort') !!}
                {!! Form::password('new_password', NULL, ['maxlength' => 255]) !!}
            </div>

            <div>
                {!! Form::label('Passwort bestätigen') !!}
                {!! Form::password('new_password_confirmation', NULL, ['maxlength' => 255]) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/profile') !!}
                {!! Form::submit('Änderungen speichern') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}
@stop
