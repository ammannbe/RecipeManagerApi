@extends('layouts.master')


@section('title', 'Autor hinzufügen')


@section('class', 'author form')
@section('content')
    {!! Form::open(['url' => 'authors/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Autor hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
