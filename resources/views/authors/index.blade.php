@extends('layouts.master')


@section('title', __('author.index.title'))


@section('content-class', 'author index')
@section('content')

    <ul>
        @foreach ($authors as $author)
            <li>
                <a href="{{ route('authors.show', $author->slug) }}">{{ $author->name }}</a>
            </li>
        @endforeach
    </ul>

@stop
