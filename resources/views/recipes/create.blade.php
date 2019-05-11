@extends('layouts.master')


@section('title', __('forms.recipe.create'))


@section('content-class', 'recipe-form')
@section('content')

    {{ Form::open(['url' => 'recipes', 'enctype="multipart/form-data"', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', __('forms.global.name'),
                ['class' => 'required']) }}
            {{ Form::text('name', NULL, [
                'placeholder' => __('forms.recipe.examples.name'),
                'maxlength'   => 200,
                'class'       => 'w3-input',
                'required', 'autofocus']) }}
        </p>

        <p>
            {{ Form::label('author_id', __('forms.recipe.author'), [
                'class' => 'required']) }}
            {{ Form::select('author_id',
                $authors, $default['authors'],
                ['class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('category_id', __('forms.recipe.category'),
                ['class' => 'required']) }}
            {{ Form::select('category_id', $categories, NULL,
                ['class' => 'js-dropdown w3-input']) }}
        </p>

        <p>
            {{ Form::label('yield_amount', __('forms.recipe.yield_amount')) }}
            {{ Form::number('yield_amount', 4, [
                'max'   => 999,
                'size'  => 3,
                'class' => 'w3-input']) }}
        </p>

        <p>
            {{ Form::label('preparation_time', __('forms.recipe.preparation_time')) }}
            {{ Form::time('preparation_time', NULL, ['class' => 'w3-input']) }}
        </p>


        <p>
            {{ Form::label('instructions', __('forms.recipe.instructions'), ['class' => 'required']) }}
            {{ Form::textarea('instructions', NULL, ['maxlength' => 16777215, 'required', 'class' => 'w3-input w3-border']) }}
        </p>


        <p>
            {{ Form::label('photo', __('forms.recipe.photo')) }}
            {{ Form::file('photo', ['class' => 'w3-input']) }}
            {{ Form::hidden('MAX_FILE_SIZE', '2097152') }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right w3-margin-bottom']) !!}
            {{ Form::button(__('forms.recipe.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left w3-margin-bottom',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
