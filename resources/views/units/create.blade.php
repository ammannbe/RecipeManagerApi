@extends('layouts.master')


@section('title', 'Einheit hinzufügen')


@section('content-class', 'unit form')
@section('content')

    {!! Form::open(['url' => 'units/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name (Singular)', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'placeholder' => 'Bsp: Flasche', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::label('Abkürzung (Singular)') !!}
                {!! Form::text('name_shortcut', NULL, ['maxlength' => 20, 'placeholder' => 'Bsp: Fl.']) !!}
            </div>

            <div>
                {!! Form::label('Name (Plural)') !!}
                {!! Form::text('name_plural', NULL, ['maxlength' => 20, 'placeholder' => 'Bsp: Flaschen']) !!}
            </div>

            <div>
                {!! Form::label('Abkürzung (Plural)') !!}
                {!! Form::text('name_plural_shortcut', NULL, ['maxlength' => 20, 'placeholder' => 'Bsp: Fl.']) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/admin') !!}
                {!! Form::submit('Einheit hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
