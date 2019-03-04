@extends('layouts.master')


@section('title', 'Rezept '.$recipe->name.' bearbeiten')


@section('content-class', 'recipe form')
@section('content')

    {!! Form::open(['url' => 'recipes/edit/'.$recipe->id, 'files' => true]) !!}

        {!! FormHelper::groups(['cluster', 'input']) !!}
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', $recipe->name, ['maxlength' => 200, 'required', 'autofocus']) !!}
        {!! FormHelper::close(2) !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kochbuch', NULL, ['class' => 'required']) !!}
                {!! Form::text('cookbook', $cookbooks[$recipe->cookbook_id], [
                    'maxlength' => 200,
                    'class' => 'text-input',
                    'autocomplete' => 'off',
                    'required']) !!}

                {!! FormHelper::jsDropdown($cookbooks) !!}
            </div>

            <div>
                {!! Form::label('Autor') !!}
                {!! Form::text('author', ($recipe->author_id ? $authors[$recipe->author_id] : NULL), [
                    'maxlength' => 200,
                    'class' => 'text-input',
                    'autocomplete' => 'off']) !!}

                @if (isset($authors))
                    {!! FormHelper::jsDropdown($authors) !!}
                @endif
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kategorie', NULL, ['class' => 'required']) !!}
                {!! Form::text('category', ($recipe->category_id ? $categories[$recipe->category_id] : NULL), [
                    'maxlength'     => 50,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'required']) !!}
                {!! FormHelper::jsDropdown($categories) !!}
            </div>

            <div>
                {!! Form::label('Portionen') !!}
                {!! Form::number('yield_amount', $recipe->yield_amount, ['max' => 999, 'size' => 3]) !!}
            </div>

            <div>
                {!! Form::label('Zubereitungszeit') !!}
                {!! Form::time('preparation_time', date('H:i', strtotime($recipe->preparation_time))) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            {!! Form::label('Zubereitung', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('instructions', $recipe->instructions, ['required']) !!}
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
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
                {!! Form::submit('Änderungen speichern') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
