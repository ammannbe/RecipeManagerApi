@extends('layouts.master')


@section('title', 'Bewertung bearbeiten')


@section('content-class', 'rating-form')
@section('content')

    {{ Form::open(['url' => "ratings/edit/{$rating->id}", 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('rating', 'Bewertung') }}
            {!! FormHelper::rating($rating->stars) !!}
        </p>

        <p>
            {{ Form::label('rating_criterion_id', 'Kriterium',
                ['class' => 'required']) }}
            {{ Form::select('rating_criterion_id',
                $ratingCriteria, $rating->rating_criterion_id,
                ['class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('comment', 'Kommentar',
            ['class' => 'required']) }}
            {{ Form::textarea('comment', $rating->comment, [
                'maxlength' => 16777215,
                'class'     => 'w3-input w3-border',
                'required']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen',
                ['class' => 'w3-btn w3-black w3-left w3-margin-right'],
                "/recipes/{$recipe->slug}") !!}
            {{ Form::button('Änderungen speichern', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
