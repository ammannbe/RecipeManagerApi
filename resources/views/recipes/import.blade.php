@extends('layouts.master')


@section('title', __('forms.import.create'))


@section('content-class', 'import form')
@section('content')

    {{ Form::open(['url' => 'recipes/import', 'enctype="multipart/form-data"', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('file', __('forms.import.file')) }}
            {{ Form::file('file', ['class' => 'w3-input']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'),
                ['class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button(__('forms.import.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {!! Form::close() !!}

@stop
