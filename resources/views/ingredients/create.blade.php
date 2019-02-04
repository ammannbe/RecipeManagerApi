@extends('layouts.master')


@section('title', 'Zutat hinzufügen')


@section('content-class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => 'ingredients/create/']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 50, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Zutat hinzufügen') !!}
        </div>
    {!! Form::close() !!}

@stop
