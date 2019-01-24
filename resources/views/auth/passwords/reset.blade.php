@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Passwort zurück setzen')


@section('class', 'reset-password form')
@section('content')
    {!! Form::open(['url' => route('password.update')]) !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            {!! Form::label('E-Mail') !!}
            {!! Form::email('email', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::label('Passwort') !!}
            {!! Form::password('password', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::label('Passwort bestätigen') !!}
            {!! Form::password('password_confirmation', NULL, ['maxlength' => 255]) !!}
        </div>

        <div>
            {!! Form::submit('Passwort zurück setzen') !!}
        </div>
    {!! Form::close() !!}
@endsection
