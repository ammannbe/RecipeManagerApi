@extends('layouts.master')


@section('title', 'Bewertung hinzufügen')


@section('content-class', 'ingredient form')
@section('content')

    {!! Form::open(['url' => "ratings/add/{$recipe->slug}"]) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kriterium', NULL, ['class' => 'required']) !!}
                {!! Form::text('rating_criterion', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}

                {!! FormHelper::jsDropdown($ratingCriteria) !!}
            </div>

            <div>
                {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
                {!! Form::textarea('comment', NULL, ['maxlength' => 16777215, 'required']) !!}
            </div>

            <div>
                {!! Form::submit('Bewertung hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
