@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Zutat hinzufügen')


@section('class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => 'ingredients/create/']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Zutat hinzufügen') !!}
        </div>

{!! Form::close() !!}

@stop
