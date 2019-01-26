@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Rezept '.$recipe->name.' bearbeiten')


@section('class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/edit/'.$recipe->id, 'files' => true]) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', $recipe->name, ['maxlength' => 200, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::select('cookbook_id', $cookbooks, $recipe->cookbook_id) !!}
        </div>

        <div>
            {!! Form::label('Autor') !!}
            {!! Form::select('author_id', $authors, $recipe->author_id) !!}
        </div>

        @php
            $selectedCategories = [];
            foreach ($recipe->categories as $category) {
                array_push($selectedCategories, $category->id);
            }
        @endphp
        <div>
            {!! Form::label('Kategorien') !!}
            {!! Form::select('categories[]', $categories, $selectedCategories, ['multiple']) !!}
        </div>

        <div>
            {!! Form::label('Portionen') !!}
            {!! Form::number('yield_amount', $recipe->yield_amount, ['max' => 99999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Portionen maximal') !!}
            {!! Form::number('yield_amount', $recipe->yield_amount_max, ['max' => 99999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Zubereitung', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('instructions', $recipe->instructions, ['required']) !!}
        </div>

        <div class="checkbox">
            {!! Form::label('Altes Foto löschen (falls vorhanden)?') !!}
            {!! Form::checkbox('delete_photo') !!}
        </div>

        <div>
            {!! Form::label('Altes Foto überschreiben (max 2MB)') !!}
            {!! Form::file('photo') !!}
            {!! Form::hidden('MAX_FILE_SIZE', '2097152') !!}
        </div>

        <div>
            {!! Form::label('Zubereitungszeit') !!}
            {!! Form::time('preparation_time', NULL) !!}
        </div>

        <div>
            {!! Form::submit('Änderungen speichern') !!}
        </div>

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
