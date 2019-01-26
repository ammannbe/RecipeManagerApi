@extends('layouts.master')


@section('title', 'Suchen')


@section('content-class', 'search form')
@section('content')
    {!! Form::open(['url' => 'search']) !!}
        <div>
            {!! Form::label('Suchen in') !!}
            {!! Form::select('table', $tables, $default) !!}
        </div>

        <div>
            {!! Form::label('Suchkriterium') !!}
            {!! Form::text('term', NULL, ['autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Rezepte suchen') !!}
        </div>
    {!! Form::close() !!}
@stop
