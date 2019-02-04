@extends('layouts.master')


@section('title', $recipe->name . ': Zutat hinzufügen')


@section('content-class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'ingredient-details/create/' . $recipe->id]) !!}
        <div>
            {!! Form::label('Menge') !!}
            {!! Form::number('amount', NULL, ['max' => 99999999, 'size' => 8, 'step' => '0.25', 'autofocus']) !!}
        </div>
        <div>
            {!! Form::label('Maximale Menge') !!}
            {!! Form::number('amount_max', NULL, ['max' => 99999999, 'size' => 8, 'step' => '0.25']) !!}
        </div>

        <div>
            {!! Form::label('Einheit') !!}
            {!! Form::text('unit', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($units as $unit)
                    <li>{{ $unit }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Zutat', NULL, ['class' => 'required']) !!}
            {!! Form::text('ingredient', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($ingredients as $ingredient)
                    <li>{{ $ingredient }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Vorbereitung') !!}
            {!! Form::text('prep', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($preps as $prep)
                    <li>{{ $prep }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Gruppe') !!}
            {!! Form::text('ingredient_detail_group', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($ingredientDetailGroups as $ingredientDetailGroup)
                    <li>{{ $ingredientDetailGroup }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Alternative') !!}
            {!! Form::select('ingredient_detail_id', array_merge([NULL], $ingredientDetailsAlternate)) !!}
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
