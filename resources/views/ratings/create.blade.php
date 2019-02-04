@extends('layouts.master')


@section('title', 'Bewertung hinzufügen')


@section('content-class', 'ingredient form')
@section('content')
    {!! Form::open(['url' => 'ratings/add/' . $recipe->id]) !!}
        <div>
            {!! Form::label('Kriterium', NULL, ['class' => 'required']) !!}
            {!! Form::text('rating_criterion', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($ratingCriteria as $ratingCriterion)
                    <li>{{ $ratingCriterion }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('comment', NULL, ['maxlength' => 16777215, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Bewertung hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
