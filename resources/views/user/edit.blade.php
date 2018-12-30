@extends('layouts.master')


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
            {!! Form::text('current_password') !!}
        </div>

        <div>
            {!! Form::label('Neues Passwort') !!}
            {!! Form::text('new_password', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::label('Passwort bestätigen') !!}
            {!! Form::text('new_password_verified', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::submit('Rezept hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
