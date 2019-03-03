@extends('layouts.master')


@section('title', $recipe->name . ': Zutat hinzufügen')


@section('content-class', 'recipe form')
@section('content')

    {!! Form::open(['url' => 'ingredient-details/create/' . $recipe->id]) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Zutat') !!}
            </div>

            <div>
                {!! Form::number('amount', NULL, [
                    'max'   => 99999999,
                    'size'  => 8,
                    'step'  => '0.25',
                    'placeholder' => 50,
                    'autofocus']) !!}
            </div>

            <div>
                {!! Form::text('unit', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Gramm']) !!}
                {!! FormHelper::jsDropdown($units) !!}
            </div>

            <div>
                {!! Form::text('ingredient', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Mandeln',
                    'required']) !!}
                {!! FormHelper::jsDropdown($ingredients) !!}</li>
            </div>

            <div>
                {!! Form::text('prep', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'gehackt']) !!}
                {!! FormHelper::jsDropdown($preps) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Gruppe') !!}
                {!! Form::text('ingredient_detail_group', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off']) !!}
                {!! FormHelper::jsDropdown($ingredientDetailGroups) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Alternative') !!}
                {!! Form::select('ingredient_detail_id', array_merge([NULL], $ingredientDetailsAlternate)) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            {!! Form::label('Position') !!}
            {!! Form::number('position', 0, [
                'min'  => 0,
                'size' => 3,
                'step' => '1']) !!}
        {!! FormHelper::close() !!}


        {!! Form::submit('Zutat hinzufügen') !!}
    {!! Form::close() !!}

@stop
