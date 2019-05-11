@extends('layouts.master')


@section('title', __('forms.prep.create'))


@section('content-class', 'prep form')
@section('content')

    {{ Form::open(['url' => route('preps.store'), 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', __('prep.global.name')) }}
            {{ Form::text('name', NULL, [
                'maxlength'   => 40,
                'class'       => 'w3-input',
                'placeholder' => __('forms.prep.examples.name'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button(__('forms.prep.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
