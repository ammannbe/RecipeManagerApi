@extends('layouts.master')


@section('title', 'Login')


@section('content-class', 'login form')
@section('content')
    {{ Form::open(['url' => route('login')]) }}
        <div>
            {!! Form::label('username', 'Benutzername', ['class' => 'required']) !!}
            {!! Form::text('username', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('password', 'Passwort', ['class' => 'required']) !!}
            {!! Form::password('password', NULL, ['minlength' => 6, 'maxlength' => 255, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Login') !!}
        </div>
    {{ Form::close() }}
@endsection
