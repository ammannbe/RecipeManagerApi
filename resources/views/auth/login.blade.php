@extends('layouts.master')


@section('title', __('forms.auth.login'))


@section('content-class', 'login form')
@section('content')

    {{ Form::open(['url' => route('login'), 'class' => 'w3-container w3-card-4 w3-padding']) }}

        {{ Form::hidden('redirect', url()->previous()) }}

        <p>
            <i class="man"></i>
            {{ Form::label('username', __('forms.auth.username')) }}
            {{ Form::text('username', null, [
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required', 'autofocus']) }}
        </p>
        <p>
            <i class="key"></i>
            {{ Form::label('password', __('forms.auth.password')) }}
            {{ Form::password('password', [
                'minlength' => 6,
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required']) }}
        </p>

        {{ Form::button(__('forms.auth.login'), [
            'class' => 'w3-btn w3-black w3-left w3-margin-left',
            'type' => 'submit']) }}

    {{ Form::close() }}

@endsection
