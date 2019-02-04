@extends('layouts.master')


@section('title', 'Rezept '.$recipe->name.' bearbeiten')


@section('content-class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/edit/'.$recipe->id, 'files' => true]) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', $recipe->name, ['maxlength' => 200, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::text('cookbook', $cookbooks[$recipe->cookbook_id], ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($cookbooks as $cookbook)
                    <li>{{ $cookbook }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Autor') !!}
            {!! Form::text('author', $authors[$recipe->author_id], ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($authors as $author)
                    <li>{{ $author }}</li>
                @endforeach
            </ul>
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
            {!! Form::number('yield_amount', $recipe->yield_amount, ['max' => 999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Portionen maximal') !!}
            {!! Form::number('yield_amount', $recipe->yield_amount_max, ['max' => 999, 'size' => 3]) !!}
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
    {!! Form::close() !!}
@stop
