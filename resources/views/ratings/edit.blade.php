@extends('layouts.master')


@section('title', 'Bewertung bearbeiten')


@section('content-class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => 'ratings/edit/' . $rating->id]) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kriterium', NULL, ['class' => 'required']) !!}
                {!! Form::text('rating_criterion', $ratingCriteria[$rating->rating_criterion_id], [
                    'maxlength'    => 200,
                    'class'        => 'text-input',
                    'autocomplete' => 'off',
                    'required']) !!}
                {!! FormHelper::jsDropdown($ratingCriteria) !!}
            </div>

            <div>
                {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
                {!! Form::textarea('comment', $rating->comment, ['maxlength' => 16777215, 'required']) !!}
            </div>

            <div>
                {!! Form::submit('Bewertung ändern') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
