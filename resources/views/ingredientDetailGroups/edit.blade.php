@extends('layouts.master')


@section('title', $recipe->name . ': ' . __('forms.ingredient.create'))


@section('content-class', 'ingredient-form')
@section('content')

    {{ Form::open(['url' => route('recipes.ingredient-detail-groups.update', [$recipe->slug, $ingredientDetailGroup->id]), 'class' => 'w3-container w3-card-4 w3-padding']) }}
        @method('PUT')

        <p>
            {{ Form::label('name', __('forms.global.name')) }}
            {{ Form::text('name', $ingredientDetailGroup->name, [
                'maxlength'   => 20,
                'class'       => 'w3-input',
                'placeholder' => __('forms.ingredient-detail-group.examples.name'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], "/recipes/{$recipe->slug}") !!}
            {{ Form::button(__('forms.ingredient-detail-group.edit'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
