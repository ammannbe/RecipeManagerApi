@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Rezept hinzufügen')


@section('class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/create']) !!}
        <div>
            {!! Form::label('Name') !!}
            {!! Form::text('name', NULL, ['maxlength' => 200]) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::select('cookbook_id', $cookbooks) !!}
        </div>

        <div>
            {!! Form::label('Autor') !!}
            {!! Form::select('author_id', $authors) !!}
        </div>

        <div>
            {!! Form::label('Kategorien') !!}
            {!! Form::select('categories[]', $categories, NULL, ['multiple' => 'multiple']) !!}
        </div>

        <div>
            {!! Form::label('Portionen') !!}
            {!! Form::number('yield_amount', 4, ['min' => 0, 'max' => 5, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Zubereitung') !!}
            {!! Form::textarea('instructions') !!}
        </div>

        <div>
            {!! Form::label('Foto (max 2MB)') !!}
            {!! Form::file('photo') !!}
            {!! Form::hidden('MAX_FILE_SIZE', '2097152') !!}
        </div>

        <div>
            {!! Form::label('Zubereitungszeit') !!}
            {!! Form::time('preparation_time', NULL) !!}
        </div>

        <div>
            {!! Form::submit('Rezept hinzufügen') !!}
        </div>
    {!! Form::close() !!}
@stop
