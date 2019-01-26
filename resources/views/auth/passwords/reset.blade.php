@extends('layouts.master')


@section('title', 'Passwort zurück setzen')


@section('content-class', 'reset-password form')
@section('content')
    {!! Form::open(['url' => route('password.update')]) !!}
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            {!! Form::label('E-Mail') !!}
            {!! Form::email('email', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Passwort', NULL, ['class' => 'required']) !!}
            {!! Form::password('password', NULL, ['maxlength' => 255, 'required']) !!}
        </div>

        <div>
            {!! Form::label('Passwort bestätigen', NULL, ['class' => 'required']) !!}
            {!! Form::password('password_confirmation', NULL, ['maxlength' => 255, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Passwort zurück setzen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@endsection
