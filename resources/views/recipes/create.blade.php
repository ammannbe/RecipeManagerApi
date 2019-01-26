@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Rezept hinzufügen')


@section('class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/create', 'enctype="multipart/form-data"']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 200, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::select('cookbook_id', $cookbooks) !!}
            <div class="info-text">
                Nichts gefunden? Neues <a href="{{ url('/cookbooks/create') }}" target="_blank"><i class="link"></i>Kochbuch</a> erstellen.
            </div>
        </div>

        <div>
            {!! Form::label('Autor') !!}
            {!! Form::select('author_id', $authors) !!}
            <div class="info-text">
                Nichts gefunden? Neuen <a href="{{ url('/authors/create') }}" target="_blank"><i class="link"></i>Autor</a> erstellen.
            </div>
        </div>

        <div>
            {!! Form::label('Kategorien') !!}
            {!! Form::select('categories[]', $categories, NULL, ['multiple' => 'multiple']) !!}
            <div class="info-text">
                Nichts gefunden? Neue <a href="{{ url('/categories/create') }}" target="_blank"><i class="link"></i>Kategorie</a> erstellen.
            </div>
        </div>

        <div>
            {!! Form::label('Portionen') !!}
            {!! Form::number('yield_amount', 4, ['max' => 99999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Portionen maximal') !!}
            {!! Form::number('yield_amount_max', 4, ['max' => 99999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Zubereitung') !!}
            {!! Form::textarea('instructions', NULL, ['maxlength', 16777215]) !!}
        </div>

        <div>
            {!! Form::label('photo', 'Foto (max 2MB)') !!}
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

        <div>
            <span><i class="required"></i>Diese Felder müssen ausgefüllt werden.</span>
        </div>
    {!! Form::close() !!}
@stop
