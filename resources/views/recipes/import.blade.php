@extends('layouts.master')


@section('title', 'Rezept importieren')


@section('content-class', 'import form')
@section('content')

    {!! Form::open(['url' => 'recipes/import', 'enctype="multipart/form-data"']) !!}

        {!! FormHelper::group('cluster') !!}
            <div>
                {!! Form::label('Kochbuch') !!}
                {!! Form::text('cookbook', NULL, ['maxlength' => 200, 'class' => 'text-input', 'autocomplete' => 'off', 'required']) !!}
                <i class="arrow-down"></i>
                <ul class="list-input hidden">
                    @foreach ($cookbooks as $cookbook)
                        <li>{{ $cookbook }}</li>
                    @endforeach
                </ul>
            </div>

            <div>
                {!! Form::label('file', 'Rezept (*.kreml)') !!}
                {!! Form::file('file') !!}
            </div>

            <div>
                {!! Form::submit('Rezept importieren') !!}
            </div>
        {!! FormHelper::close() !!}

    {!! Form::close() !!}

@stop
