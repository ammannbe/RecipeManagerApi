@extends('layouts.master')


@section('title', 'Kriterium hinzufügen')


@section('class', 'criterium form')
@section('content')
    {!! Form::open(['url' => 'rating-criteria/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Kriterium hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
