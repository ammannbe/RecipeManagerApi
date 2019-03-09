@extends('layouts.master')


@section('title', 'Autor hinzufügen')


@section('content-class', 'author form')
@section('content')

    {!! Form::open(['url' => 'authors/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 50, 'placeholder' => 'Bsp: Benjamin Ammann', 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/admin') !!}
                {!! Form::submit('Autor hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
