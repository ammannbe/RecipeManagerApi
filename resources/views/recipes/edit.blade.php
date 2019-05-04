@extends('layouts.master')


@section('title', 'Rezept '.$recipe->name.' bearbeiten')


@section('content-class', 'recipe-form')
@section('content')

{{-- https://ourcodeworld.com/articles/read/359/top-7-best-markdown-editors-javascript-and-jquery-plugins --}}

    {{ Form::open(['url' => "recipes/edit/{$recipe->slug}", 'enctype="multipart/form-data"', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('name', 'Name',
                ['class' => 'required']) }}
            {{ Form::text('name', $recipe->name, [
                'maxlength' => 200,
                'class'     => 'w3-input',
                'required', 'autofocus']) }}
        </p>

        <p>
            {{ Form::label('author_id', 'Verfasser',
                ['class' => 'required']) }}
            {{ Form::select('author_id',
                $authors, $recipe->author_id,
                ['class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('Kategorie', NULL,
                ['class' => 'required']) }}
            {{ Form::select('category_id',
                $categories, $recipe->category_id,
                ['class' => 'js-dropdown w3-select']) }}
        </p>

        <p>
            {{ Form::label('yield_amount', 'Portionen') }}
            {{ Form::number('yield_amount', $recipe->yield_amount,
                ['max' => 999, 'size' => 3, 'class' => 'w3-input']) }}
        </p>

        <p>
            {{ Form::label('preparation_time', 'Zubereitungszeit') }}
            {{ Form::time('preparation_time',
                ($recipe->preparation_time ? date('H:i', strtotime($recipe->preparation_time)) : NULL),
                ['class' => 'w3-input']) }}
        </p>

        <p>
            {{ Form::label('instructions', 'Zubereitung',
                ['class' => 'required']) }}
            {{ Form::textarea('instructions', $recipe->instructions,
                ['required', 'class' => 'w3-input w3-border']) }}
        </p>

        <p class="checkbox">
            {{ Form::label('delete_photo', 'Altes Foto löschen (falls vorhanden)?') }}
            {{ Form::checkbox('delete_photo', NULL, NULL,
                ['class' => 'w3-check']) }}
        </p>

        <p>
            {{ Form::label('photo', 'Altes Foto überschreiben (max 2MB)') }}
            {{ Form::file('photo', ['class' => 'w3-input']) }}
            {{ Form::hidden('MAX_FILE_SIZE', '2097152') }}
        </p>

        <p>
            {!! FormHelper::backButton('Abbrechen', [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'],
                "/recipes/{$recipe->slug}") !!}
            {{ Form::button('Verfasser hinzufügen', [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

@stop
