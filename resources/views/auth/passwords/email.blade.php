@extends('layouts.master')
@extends('layouts.validator')

@section('title', 'Passwort vergessen')


@section('class', 'forogt-password form')
@section('content')

    {!! Form::open(['url' => route('password.email')]) !!}
        <div>
            {!! Form::label('E-Mail Adresse') !!}
            {!! Form::email('email') !!}
        </div>

        <div>
            {!! Form::submit('Passwort zurück setzen') !!}
        </div>
    {!! Form::close() !!}
@endsection


@if (session('status'))
    <div class="toast">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            {{ session('status') }}
        </div>
    </div>
@endif
