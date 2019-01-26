@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Registrieren')


@section('class', 'register form')
@section('content')
    {!! Form::open(['url' => route('register')]) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('E-Mail', NULL, ['class' => 'required']) !!}
            {!! Form::email('email', NULL, ['maxlength' => 255, 'required']) !!}
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
            {!! Form::submit('Registrieren') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@endsection
