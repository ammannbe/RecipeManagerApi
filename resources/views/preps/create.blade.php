@extends('layouts.master')


@section('title', 'Vorbereitung hinzufügen')


@section('content-class', 'prep form')
@section('content')

    {!! Form::open(['url' => 'preps/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 40, 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::submit('Vorbereitung hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
