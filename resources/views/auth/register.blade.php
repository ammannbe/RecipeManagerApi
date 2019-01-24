@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Registrieren')


@section('class', 'register form')
@section('content')
    {!! Form::open(['url' => route('register')]) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', NULL, ['maxlength' => 255]) !!}
        </div>

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
            {!! Form::submit('Registrieren') !!}
        </div>
    {!! Form::close() !!}
@endsection
