@extends('layouts.master')


@section('title', __('forms.rating.create'))


@section('content-class', 'rating-form')
@section('content')

    {{ Form::open(['url' => "recipes/{$recipe->slug}/ratings", 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('rating', __('forms.rating.rating')) }}
            {!! FormHelper::rating() !!}
        </p>

        <p>
            {{ Form::label('rating_criterion_id', __('forms.rating.criterion'), [
                'class' => 'required']) }}
            {{ Form::select('rating_criterion_id', $ratingCriteria, null, [
                'class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('comment', __('forms.rating.comment'), ['class' => 'required']) }}
            {{ Form::textarea('comment', null, [
                'maxlength' => 16777215,
                'class'     => 'w3-input w3-border',
                'required']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], "/recipes/{$recipe->slug}") !!}
            {{ Form::button(__('forms.rating.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
