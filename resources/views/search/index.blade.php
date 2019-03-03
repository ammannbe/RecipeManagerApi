@extends('layouts.master')


@section('title', 'Suche')


@section('content-class', 'search form')
@section('content')

    {!! Form::open(['url' => 'search']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Suchen in') !!}
                {!! Form::select('item', $tables, $default) !!}
            </div>

            <div>
                {!! Form::label('Suchkriterium') !!}
                {!! Form::text('term', NULL, ['autofocus']) !!}

                {!! Form::submit('Rezepte suchen') !!}
            </div>

        {!! FormHelper::close() !!}
    {!! Form::close() !!}

@stop
