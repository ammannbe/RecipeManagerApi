@extends('layouts.master')


@section('title', __('user.admin.title'))


@section('content-class', 'admin')
@section('content')

    <ul>
        <li><a href="{{ url('/authors/create') }}">{{ __('user.admin.create_author') }}</a></li>
        <li><a href="{{ url('/categories/create') }}">{{ __('user.admin.create_category') }}</a></li>
        <li><a href="{{ url('/ingredients/create') }}">{{ __('user.admin.create_ingredient') }}</a></li>
        <li><a href="{{ url('/units/create') }}">{{ __('user.admin.create_unit') }}</a></li>
        <li><a href="{{ url('/preps/create') }}">{{ __('user.admin.create_prep') }}</a></li>
        <li><a href="{{ url('/rating-criteria/create') }}">{{ __('user.admin.create_rating_criterion') }}</a></li>
        &nbsp;
        <li><a href="{{ url('/recipes/import') }}">{{ __('user.admin.create_import') }}</a></li>
    </ul>

@stop
