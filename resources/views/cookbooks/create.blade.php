@extends('layouts.master')


@section('title', 'Kochbuch hinzufügen')


@section('class', 'cookbook form')
@section('content')
    {!! Form::open(['url' => 'cookbooks/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name') !!}
        </div>

        <div>
            {!! Form::submit('Kochbuch hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
