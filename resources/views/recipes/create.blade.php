@extends('layouts.master')


@section('title', 'Rezept hinzufügen')


@section('content-class', 'recipe form')
@section('content')
    {!! Form::open(['url' => 'recipes/create', 'enctype="multipart/form-data"']) !!}
        <div>
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, ['maxlength' => 200, 'required', 'autofocus']) !!}
        </div>

        <div>
            {!! Form::label('Kochbuch', NULL, ['class' => 'required']) !!}
            {!! Form::text('cookbook', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($cookbooks as $cookbook)
                    <li>{{ $cookbook }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Autor', NULL) !!}
            {!! Form::text('author', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off']) !!}
            <i class="arrow-down"></i>
            <ul class="list-input">
                @foreach ($authors as $author)
                    <li>{{ $author }}</li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! Form::label('Kategorien', NULL, ['class' => 'required']) !!}
            {!! Form::select('categories[]', $categories, NULL, ['multiple' => 'multiple', 'size' => 5, 'required']) !!}
        </div>

        <div>
            {!! Form::label('Portionen') !!}
            {!! Form::number('yield_amount', 4, ['max' => 999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Portionen maximal') !!}
            {!! Form::number('yield_amount_max', 4, ['max' => 999, 'size' => 3]) !!}
        </div>

        <div>
            {!! Form::label('Zubereitung', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('instructions', NULL, ['maxlength' => 16777215, 'required']) !!}
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
    {!! Form::close() !!}
@stop
