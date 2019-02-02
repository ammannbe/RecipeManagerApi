@extends('layouts.master')


@section('title', 'Bewertung bearbeiten')


@section('content-class', 'ingredient form')
@section('content')
    {!! Form::open(['url' => 'ratings/edit/' . $rating->id]) !!}
        <div>
            {!! Form::label('Kriterium') !!}
            {!! Form::select('rating_criterion_id', $ratingCriteria, $rating->rating_criterion_id) !!}
        </div>

        <div>
            {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('comment', $rating->comment, ['maxlength' => 16777215, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Bewertung hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
