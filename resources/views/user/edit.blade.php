@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Profil bearbeiten')


@section('class', 'user form')
@section('content')
    {!! Form::open(['url' => 'user/edit']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', $user->name, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::label('E-Mail') !!}
            {!! Form::text('email', $user->email, ['maxlength' => 255]) !!}
        </div>

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
            {!! Form::password('new_password_verified', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::submit('Änderungen speichern') !!}
        </div>
    {!! Form::close() !!}
@stop
