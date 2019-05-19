@extends('layouts.master')


@section('title', __('forms.author.create'))


@section('content-class', 'author form')
@section('content')

    {{ Form::open(['url' => route('authors.store'), 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', __('forms.global.name')) }}
            {{ Form::text('name', NULL, [
                'maxlength'   => 50,
                'class'       => 'w3-input',
                'placeholder' => __('forms.author.examples.name'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button(__('forms.author.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
