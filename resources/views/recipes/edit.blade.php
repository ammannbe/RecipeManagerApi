@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Rezept '.$recipe->name.' bearbeiten')


@section('class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/edit/'.$recipe->id, 'files' => true]) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', $recipe->name, ['maxlength' => 200]) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::select('cookbook_id', $cookbooks, $recipe->cookbook_id) !!}
        </div>

        <div>
            {!! Form::label('Autor') !!}
            {!! Form::select('author_id', $authors, $recipe->author_id) !!}
        </div>
        
        @php($selectedCategories = [])
        @foreach ($recipe->categories as $category)
            @php(array_push($selectedCategories, $category->id))
        @endforeach
        <div>
            {!! Form::label('Kategorien') !!}
            {!! Form::select('categories[]', $categories, $selectedCategories, ['multiple' => 'multiple']) !!}
        </div>

        <div>
            {!! Form::label('Portionen') !!}
            {!! Form::number('yield_amount', $recipe->yield_amount, ['min' => 0, 'max' => 99999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Zubereitung') !!}
            {!! Form::textarea('instructions', $recipe->instructions) !!}
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
