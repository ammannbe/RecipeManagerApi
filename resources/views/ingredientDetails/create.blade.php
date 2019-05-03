@extends('layouts.master')


@section('title', $recipe->name . ': Zutat hinzufügen')


@section('content-class', 'ingredient-form')
@section('content')

    {{ Form::open(['url' => "ingredient-details/create/{$recipe->slug}", 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('amount', 'Zutat') }}
            <p>
                {{ Form::number('amount', NULL, [
                    'max'   => 999999.99,
                    'min'   => 0,
                    'size'  => 8,
                    'step'  => '0.25',
                    'class' => 'w3-inpupt',
                    'placeholder' => 'z.B. 50',
                    'autofocus']) }}
                {{ Form::select('unit_id', $units, NULL, ['class' => 'js-dropdown w3-select w3-third']) }}
                {{ Form::select('ingredient_id', $ingredients, NULL, ['class' => 'js-dropdown w3-select w3-third']) }}
            </p>
        </p>
        <p>
            {{ Form::label('preps', 'Eigenschaft') }}
            {{ Form::select('preps[]', $preps, NULL, ['size' => 7, 'multiple', 'class' => 'w3-select w3-border']) }}
        </p>

        <p>
            {{ Form::label('ingredient_detail_group', 'Gruppe') }}
            {{ Form::select(
                'ingredient_detail_group',
                $ingredientDetailGroups,
                $default['ingredientDetailGroup'],
                ['class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('ingredient_detail_id', 'Dieses Rezept als Alternative zu:') }}
            {{ Form::select('ingredient_detail_id', $ingredientDetailsAlternate, [NULL], ['class' => 'js-dropdown w3-input']) }}
        </p>

        <p>
            {{ Form::label('position', 'Position') }}
            {{ Form::number('position', 0, [
                'min'   => 0,
                'size'  => 3,
                'step'  => '1',
                'class' => 'w3-input']) }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], "/recipes/{$recipe->slug}") !!}
            {{ Form::button('Zutat hinzufügen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
