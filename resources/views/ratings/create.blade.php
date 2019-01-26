@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Bewertung hinzufügen')


@section('class', 'ingredient form')
@section('content')
    {!! Form::open(['url' => 'ratings/add/' . $recipe->id]) !!}
        <div>
            {!! Form::label('Kriterium') !!}
            {!! Form::select('rating_criterion_id', $ratingCriteria) !!}
            <div class="info-text">
                Nichts gefunden? Neues <a href="{{ url('/rating-criteria/create') }}" target="_blank"><i class="link"></i>Kriterium</a> erstellen.
            </div>
        </div>

        <div>
            {!! Form::label('Kommentar', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('comment', NULL, ['maxlength' => 16777215, 'required']) !!}
        </div>

        <div>
            {!! Form::submit('Bewertung hinzufügen') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
