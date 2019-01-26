@extends('layouts.master')


@section('title', 'Kochbuch hinzufügen')


@section('class', 'cookbook form')
@section('content')
    {!! Form::open(['url' => 'cookbooks/create']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 20, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::submit('Kochbuch hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
