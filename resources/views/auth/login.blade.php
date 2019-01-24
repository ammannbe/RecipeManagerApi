@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Login')


@section('class', 'login form')
@section('content')
    {{ Form::open(['url' => route('login')]) }}
        <div>
            {!! Form::label('E-Mail') !!}
            {!! Form::email('email', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Passwort') !!}
            {!! Form::password('password', NULL, ['maxlength' => 255, 'required']) !!}
            <small>Passwort vergessen? <a href="{{ url('password/reset') }}">Hier zurück setzen.</a></small>
        </div>

        <div>
            {!! Form::submit('Registrieren') !!}
        </div>
    {{ Form::close() }}
@endsection
