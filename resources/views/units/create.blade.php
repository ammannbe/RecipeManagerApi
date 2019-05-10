@extends('layouts.master')


@section('title', __('forms.unit.create'))


@section('content-class', 'unit form')
@section('content')

    {{ Form::open(['url' => 'units/create', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', __('form.unit.name'), ['class' => 'required']) }}
            {{ Form::text('name', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => __('form.unit.examples.name'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {{ Form::label('name_shortcut', __('form.unit.name_shortcut')) }}
            {{ Form::text('name_shortcut', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => __('form.unit.examples.name_shortcut')]) }}
        </p>

        <p>
            {{ Form::label('name_plural', __('form.unit.name_plural')) }}
            {{ Form::text('name_plural', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => __('form.unit.examples.name_plural')]) }}
        </p>

        <p>
            {{ Form::label('name_plural_shortcut', __('form.unit.name_plural_shortcut')) }}
            {{ Form::text('name_plural_shortcut', NULL, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => __('form.unit.examples.name_plural_shortcut')]) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('form.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], '/admin') !!}
            {{ Form::button(__('form.unit.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
