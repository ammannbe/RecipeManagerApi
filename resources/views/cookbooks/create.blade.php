@extends('layouts.master')


@section('title', 'Kochbuch hinzufügen')


@section('content-class', 'cookbook form')
@section('content')

    {!! Form::open(['url' => 'cookbooks/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'placeholder' => 'Bsp: Narrenhaus', 'autofocus']) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], '/admin') !!}
                {!! Form::submit('Kochbuch hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
