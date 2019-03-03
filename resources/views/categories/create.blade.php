@extends('layouts.master')


@section('title', 'Kategorie hinzufügen')


@section('content-class', 'category form')
@section('content')

    {!! Form::open(['url' => 'categories/create']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Name', NULL, ['class' => 'required']) !!}
                {!! Form::text('name', NULL, ['maxlength' => 50, 'placeholder' => 'Bsp: Dessert', 'required', 'autofocus']) !!}
            </div>

            <div>
                {!! Form::submit('Kategorie hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
