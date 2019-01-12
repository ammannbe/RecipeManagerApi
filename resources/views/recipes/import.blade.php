@extends('layouts.master')
@extends('layouts.validator')


@section('title', 'Rezept importieren')


@section('class', 'import form')
@section('content')
    {!! Form::open(['url' => 'recipes/import', 'enctype="multipart/form-data"']) !!}
        <div>
            {!! Form::label('Kochbuch') !!}
            {!! Form::select('cookbook_id', $cookbooks) !!}
            <div class="info-text">
                Nichts gefunden? Neues <a href="{{ url('/cookbooks/create') }}" target="_blank"><i class="link"></i>Kochbuch</a> erstellen.
            </div>
        </div>

        <div>
            {!! Form::label('file', 'Rezept') !!}
            {!! Form::file('file') !!}
        </div>

        <div>
            {!! Form::submit('Rezept importieren') !!}
        </div>
    {!! Form::close() !!}
@stop
