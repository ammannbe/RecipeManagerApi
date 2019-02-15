@extends('layouts.master')


@section('title', 'Kriterium hinzufügen')


@section('content-class', 'criterion form')
@section('content')

    {!! Form::open(['url' => 'rating-criteria/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::submit('Kriterium hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
