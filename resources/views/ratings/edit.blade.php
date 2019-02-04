@extends('layouts.master')


@section('title', 'Bewertung bearbeiten')


@section('content-class', 'ingredient form')
@section('content')
    {!! Form::open(['url' => 'ratings/edit/' . $rating->id]) !!}
        <div>
            {!! Form::label('Kriterium') !!}
            {!! Form::text('rating_criterion', $default['ratingCriterion']->name, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($ratingCriteria as $ratingCriterion)
                    <li>{{ $ratingCriterion }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('comment', $rating->comment, ['maxlength' => 16777215, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Bewertung ändern') !!}
        </div>
    {!! Form::close() !!}
@stop
