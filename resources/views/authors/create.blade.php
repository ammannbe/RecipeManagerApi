@extends('layouts.master')


@section('title', 'Autor hinzufügen')


@section('class', 'author form')
@section('content')
    {!! Form::open(['url' => 'authors/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', NULL, ['maxlength' => 50, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Autor hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
