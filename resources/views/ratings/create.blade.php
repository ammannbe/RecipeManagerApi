@extends('layouts.master')


@section('title', 'Bewertung hinzufügen')


@section('content-class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => "ratings/add/{$recipe->slug}"]) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kriterium', NULL, ['class' => 'required']) !!}
                {!! Form::select('rating_criterion_id', $ratingCriteria, NULL, ['class' => 'js-dropdown']) !!}
            </div>

            <div>
                {!! Form::label('Bewertung') !!}
                {!! FormHelper::rating() !!}
            </div>

            <div>
                {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
                {!! Form::textarea('comment', NULL, ['maxlength' => 16777215, 'required']) !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], "/recipes/$recipe->slug") !!}
                {!! Form::submit('Bewertung hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
