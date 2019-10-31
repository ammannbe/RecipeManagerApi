@extends('layouts.master')


@section('title', __('forms.category.create'))


@section('content-class', 'category form')
@section('content')

    {{ Form::open(['url' => route('categories.store'), 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', __('forms.global.name')) }}
            {{ Form::text('name', null, [
                'maxlength' => 50,
                'class'     => 'w3-input',
                'placeholder' => __('forms.category.examples.name'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button(__('forms.category.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
