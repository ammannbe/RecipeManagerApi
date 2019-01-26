@extends('layouts.master')


@section('title', 'Passwort vergessen')


@section('content-class', 'forogt-password form')
@section('content')

    {!! Form::open(['url' => route('password.email')]) !!}
        <div>
            {!! Form::label('E-Mail Adresse', NULL, ['class' => 'required']) !!}
            {!! Form::email('email', NULL, ['maxlength' => 255, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Passwort zurück setzen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@endsection


@if (session('status'))
    @php(\Toast::success(session('status')))
@endif
