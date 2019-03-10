@extends('layouts.master')


@section('title', 'Kriterium hinzufügen')


@section('content-class', 'criterion form')
@section('content')

    {!! Form::open(['url' => 'rating-criteria/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 20, 'placeholder' => 'Bsp: Geschmack', 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/admin') !!}
                {!! Form::submit('Kriterium hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
