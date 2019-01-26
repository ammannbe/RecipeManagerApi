@extends('layouts.master')


@section('title', 'Einheit hinzufügen')


@section('class', 'unit form')
@section('content')
    {!! Form::open(['url' => 'units/create']) !!}
        <div>
            {!! Form::label('Name (Singular)', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Abkürzung (Singular)') !!}
            {!! Form::text('name_shortcut', NULL, ['maxlength' => 20]) !!}
        </div>

        <div>
            {!! Form::label('Name (Plural)') !!}
            {!! Form::text('name_plural', NULL, ['maxlength' => 20]) !!}
        </div>

        <div>
            {!! Form::label('Abkürzung (Plural)') !!}
            {!! Form::text('name_plural_shortcut', NULL, ['maxlength' => 20]) !!}
        </div>

        <div>
            {!! Form::submit('Einheit hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
