@extends('layouts.master')


@section('title', 'Login')


@section('content-class', 'login form')
@section('content')
    {{ Form::open(['url' => route('login')]) }}
        <div>
            {!! Form::label('email', 'E-Mail', ['class' => 'required']) !!}
            {!! Form::email('email', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('password', 'Passwort', ['class' => 'required']) !!}
            {!! Form::password('password', NULL, ['minlength' => 6, 'maxlength' => 255, 'required']) !!}
            <small>Passwort vergessen? <a href="{{ url('password/reset') }}">Hier zurück setzen.</a></small>
        </div>

        <div>
            {!! Form::submit('Login') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {{ Form::close() }}
@endsection
