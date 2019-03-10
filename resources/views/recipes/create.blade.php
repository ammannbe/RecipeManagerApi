@extends('layouts.master')


@section('title', 'Rezept hinzufügen')


@section('content-class', 'recipe form')
@section('content')

    {!! Form::open(['url' => 'recipes/create', 'enctype="multipart/form-data"']) !!}

        {!! FormHelper::groups(['cluster', 'input']) !!}
            {!! Form::label('Name', NULL, ['class' => 'required']) !!}
            {!! Form::text('name', NULL, [
                'placeholder' => 'Benis Spezialkukis',
                'maxlength'   => 200,
                'required', 'autofocus']) !!}
        {!! FormHelper::close(2) !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! FormHelper::group('input') !!}
                    {!! Form::label('Kochbuch', NULL, ['class' => 'required']) !!}
                    {!! Form::text('cookbook', reset($cookbooks), [
                        'maxlength'     => 200,
                        'class'         => 'text-input',
                        'autocomplete'  => 'off',
                        'required', 'readonly']) !!}
                {!! FormHelper::close() !!}
            </div>

            <div>
                {!! FormHelper::group('input') !!}
                    @php
                        $default = array_search(auth()->user()->name, $authors);
                    @endphp
                    {!! Form::label('Autor', NULL, ['class' => 'required']) !!}
                    {!! Form::text('author', $authors[$default], [
                        'maxlength'     => 200,
                        'class'         => 'text-input',
                        'autocomplete'  => 'off',
                        'required']) !!}
                    {!! FormHelper::jsDropdown($authors) !!}
                {!! FormHelper::close() !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kategorie', NULL, ['class' => 'required']) !!}
                {!! Form::text('category', NULL, [
                    'maxlength'     => 50,
                    'class'         => 'text-input',
                    'autocomplete'  => 'off',
                    'required']) !!}
                {!! FormHelper::jsDropdown($categories) !!}
            </div>

            <div>
                {!! Form::label('Portionen') !!}
                {!! Form::number('yield_amount', 4, ['max' => 999, 'size' => 3]) !!}
            </div>

            <div>
                {!! Form::label('Zubereitungszeit') !!}
                {!! Form::time('preparation_time', NULL) !!}
            </div>
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            {!! Form::label('Zubereitung', NULL, ['class' => 'required']) !!}
            {!! Form::textarea('instructions', NULL, ['maxlength' => 16777215, 'required']) !!}
        {!! FormHelper::close() !!}


        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('photo', 'Foto (max. 2MB)') !!}
                {!! Form::file('photo') !!}
                {!! Form::hidden('MAX_FILE_SIZE', '2097152') !!}
            </div>

            <div>
                {!! FormHelper::backButton('Abbrechen', ['class' => 'button']) !!}
                {!! Form::submit('Rezept hinzufügen') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
