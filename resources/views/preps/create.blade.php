@extends('layouts.master')


@section('title', 'Vorbereitung hinzufügen')


@section('class', 'prep form')
@section('content')
    {!! Form::open(['url' => 'preps/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Vorbereitung hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
