@extends('layouts.master')


@section('title', 'Kriterium hinzufügen')


@section('class', 'criterium form')
@section('content')
    {!! Form::open(['url' => 'rating-criteria/create']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Kriterium hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
