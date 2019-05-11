@extends('layouts.master')


@section('title', __('category.index.title'))


@section('content-class', 'category index')
@section('content')

    <ul>
        @foreach ($categories as $category)
            <li>
                <a href="{{ route('categories.show', $category->slug) }}">{{ $category->name }}</a>
            </li>
        @endforeach
    </ul>

@stop
