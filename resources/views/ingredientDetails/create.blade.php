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
                {!! Form::text('unit', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'z.B. Gramm']) !!}
                {!! FormHelper::jsDropdown($units) !!}
            </div>

            <div>
                {!! Form::text('ingredient', NULL, [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'z.B. Mandeln',
                    'required']) !!}
                {!! FormHelper::jsDropdown($ingredients) !!}</li>
            </div>

            <div>
                {!! Form::select('preps[]', $preps, NULL, ['size' => 7, 'multiple']) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Gruppe') !!}
                {!! Form::text('ingredient_detail_group', $default['ingredientDetailGroup'], [
                    'maxlength'     => 200,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'z.B. Sauce']) !!}
                {!! FormHelper::jsDropdown($ingredientDetailGroups) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Oder') !!}
                {!! Form::select('ingredient_detail_id', $ingredientDetailsAlternate, [NULL]) !!}
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
