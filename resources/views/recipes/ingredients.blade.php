@extends('layouts.master')


@section('title', $recipe->name . ': Zutaten hinzufügen')


@section('class', 'recipe form')
@section('content')

    {!! Form::open(['url' => 'ingredients/add/' . $recipe->id]) !!}
        <div>
            {!! Form::label('Menge') !!}
            {!! Form::number('amount', 1, ['min' => 0, 'max' => 99999999, 'size' => 8, 'step' => '0.25']) !!}
        </div>

        <div>
            {!! Form::label('Einheit') !!}
            {!! Form::select('unit_id', $units) !!}
        </div>

        <div>
            {!! Form::label('Zutat') !!}
            {!! Form::select('ingredient_id', $ingredients) !!}
        </div>

        <div>
            {!! Form::label('Vorbereitung') !!}
            {!! Form::select('prep_id', $preps) !!}
        </div>

        <div>
            {!! Form::label('Position') !!}
            {!! Form::number('position', 0, ['min' => 0, 'size' => 3, 'step' => '1']) !!}
        </div>

        <div>
            {!! Form::submit('Zutat hinzufügen') !!}
        </div>

{!! Form::close() !!}

@stop
