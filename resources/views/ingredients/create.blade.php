@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Zutat hinzufügen')


@section('class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => 'ingredients/create/']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', NULL, ['maxlength' => 50, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Zutat hinzufügen') !!}
        </div>

{!! Form::close() !!}

@stop
