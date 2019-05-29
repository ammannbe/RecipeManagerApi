@extends('layouts.master')


@section('title', __('forms.search.create'))
@section('meta-description', __('forms.search.meta_description', ['count' => \App\Models\Recipe::count() - 5]))


@section('content-class', 'search form')
@section('content')

    {{ Form::open(['url' => 'search', 'class' => 'w3-container w3-card-4 w3-padding']) }}

        <p>
            {{ Form::label('item', __('forms.search.item')) }}
            {{ Form::select('item', $tables, $default, [
                'class' => 'w3-input']) }}
        </p>

        <p>
            {{ Form::label('term', __('forms.search.term'), ['class' => 'required']) }}
            {{ Form::text('term', NULL, [
                'class'       => 'w3-input',
                'placeholder' => __('forms.search.examples.term'),
                'required', 'autofocus']) }}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right']) !!}
            {{ Form::button(__('forms.search.create'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {{ Form::close() }}

    <br>

    <div class="w3-container w3-card w3-padding w3-margin-top">
        <h3>{{ __('forms.search.category.title') }}</h3>
        <p>
            {{ __('forms.search.category.text') }}
            <a href="{{ route('categories.index') }}">{{ __('forms.global.next') }}<i class="arrow-right"></i></a>
        </p>
    </div>

    <div class="w3-container w3-card w3-padding w3-margin-top">
        <h3>{{ __('forms.search.author.title') }}</h3>
        <p>
            {{ __('forms.search.author.text') }}
            <a href="{{ route('authors.index') }}">{{ __('forms.global.next') }}<i class="arrow-right"></i></a>
        </p>
    </div>

    <div class="w3-container w3-card w3-padding w3-margin-top">
        <h3>{{ __('forms.search.tag.title') }}</h3>
        <p>
            {{ __('forms.search.tag.text') }}
            <a href="{{ route('tags.index') }}">{{ __('forms.global.next') }}<i class="arrow-right"></i></a>
        </p>
    </div>

@stop
