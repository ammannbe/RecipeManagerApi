@extends('layouts.master')


@section('title', __('user.admin.title'))


@section('content-class', 'admin')
@section('content')

    <ul>
        <li><a href="{{ route('authors.create') }}">{{ __('user.admin.create_author') }}</a></li>
        <li><a href="{{ route('categories.create') }}">{{ __('user.admin.create_category') }}</a></li>
        <li><a href="{{ route('ingredients.create') }}">{{ __('user.admin.create_ingredient') }}</a></li>
        <li><a href="{{ route('units.create') }}">{{ __('user.admin.create_unit') }}</a></li>
        <li><a href="{{ route('preps.create') }}">{{ __('user.admin.create_prep') }}</a></li>
        <li><a href="{{ route('rating-criteria.create') }}">{{ __('user.admin.create_rating_criterion') }}</a></li>
        &nbsp;
        <li><a href="{{ route('import.create') }}">{{ __('user.admin.create_import') }}</a></li>
    </ul>

@stop
