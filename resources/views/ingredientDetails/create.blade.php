@extends('layouts.master')


@section('title', $recipe->name . ': Zutat hinzufügen')


@section('content-class', 'recipe form')
@section('content')

    {!! Form::open(['url' => "ingredient-details/create/{$recipe->slug}"]) !!}

        {!! FormHelper::backButton('<i class="arrow-left"></i>Zurück', [], "/recipes/{$recipe->slug}") !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Zutat') !!}
            </div>

            <div>
                {!! Form::number('amount', NULL, [
                    'max'   => 999999.99,
                    'min'   => 0,
                    'size'  => 8,
                    'step'  => '0.25',
                    'placeholder' => 'z.B. 50',
                    'autofocus']) !!}
            </div>

            <div>
                {!! Form::select('unit_id', $units, NULL, ['class' => 'js-dropdown']) !!}
            </div>

            <div>
                {!! Form::select('ingredient_id', $ingredients, NULL, ['class' => 'js-dropdown']) !!}
            </div>

            <div>
                {!! Form::select('preps[]', $preps, NULL, ['size' => 7, 'multiple']) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Gruppe') !!}
                {!! Form::select(
                        'ingredient_detail_group',
                        $ingredientDetailGroups,
                        $default['ingredientDetailGroup'],
                        ['class' => 'js-dropdown'])
                    !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Dieses Rezept als Alternative zu:') !!}
                {!! Form::select('ingredient_detail_id', $ingredientDetailsAlternate, [NULL], ['class' => 'js-dropdown']) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Position') !!}
                {!! Form::number('position', 0, [
                    'min'  => 0,
                    'size' => 3,
                    'step' => '1']) !!}
            </div>
            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button'], "/recipes/{$recipe->slug}") !!}
                {!! Form::submit('Zutat hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
