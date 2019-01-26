@extends('layouts.master')


@section('title', 'Kategorie hinzufügen')


@section('content-class', 'category form')
@section('content')
    {!! Form::open(['url' => 'categories/create']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 50, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Kategorie hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
