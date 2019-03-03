@extends('layouts.master')


@section('title', 'Zutat hinzufügen')


@section('content-class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => 'ingredients/create/']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 50, 'required', 'placeholder' => 'Bsp: Kürbis', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::submit('Zutat hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
