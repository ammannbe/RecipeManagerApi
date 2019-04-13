@extends('layouts.master')


@section('title', 'Rezept importieren')


@section('content-class', 'import form')
@section('content')

    {!! Form::open(['url' => 'recipes/import', 'enctype="multipart/form-data"']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('file', 'Rezept (*.kreml)') !!}
                {!! Form::file('file') !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/admin') !!}
                {!! Form::submit('Rezept importieren') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
