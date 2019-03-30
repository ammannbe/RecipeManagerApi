@extends('layouts.master')


@section('title', 'Suche')
@section('meta-description', 'Einfach und schnell in über ' . (\App\Recipe::count() - rand(5, 10)) . ' Rezepten suchen.')


@section('content-class', 'search form')
@section('content')

    {!! Form::open(['url' => 'search']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('item', 'Suchen in') !!}
                {!! Form::select('item', $tables, $default) !!}
            </div>

            <div>
                {!! Form::label('term', 'Suchkriterium') !!}
                {!! Form::text('term', NULL, ['autofocus']) !!}

                {!! Form::submit('Rezepte suchen') !!}
            </div>

        {!! FormHelper::close() !!}
    {!! Form::close() !!}

@stop
