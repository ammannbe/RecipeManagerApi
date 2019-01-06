@extends('layouts.master')


@section('title', 'Kategorie hinzufügen')


@section('class', 'category form')
@section('content')
    {!! Form::open(['url' => 'categories/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Kategorie hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
