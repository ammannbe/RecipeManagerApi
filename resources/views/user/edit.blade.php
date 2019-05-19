@extends('layouts.master')


@section('title', __('forms.user.edit'))


@section('content-class', 'user-form')
@section('content')
    {{ Form::open(['url' => route('user.update'), 'class' => 'w3-container w3-card-4 w3-padding']) }}
        @method('PUT')

        <p>
            {!! Form::label('name', __('forms.global.name'),
                ['class' => 'required']) !!}
            {!! Form::text('name', $user->name, [
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required', 'autofocus']) !!}
        </p>

        <p>
            {!! Form::label('email', __('forms.user.email'), ['class' => 'required']) !!}
            {!! Form::email('email', $user->email, [
                'maxlength' => 255,
                'class'     => 'w3-input',
                'required']) !!}
        </p>

        <p>
            {!! Form::label('current_password', __('forms.user.current_password')) !!}
            {!! Form::password('current_password', [
                'maxlength' => 255,
                'class'     => 'w3-input']) !!}
            <small>{{ __('forms.user.let_empty') }}</small>
        </p>

        <p>
            {!! Form::label('new_password', __('forms.user.new_password')) !!}
            {!! Form::password('new_password', [
                'maxlength' => 255,
                'class'     => 'w3-input']) !!}
        </p>

        <p>
            {!! Form::label('new_password_confirmation', __('forms.user.new_password_confirm')) !!}
            {!! Form::password('new_password_confirmation', [
                    'maxlength' => 255,
                    'class'     => 'w3-input']) !!}
        </p>

        <p>
            {!! FormHelper::backButton(__('forms.global.cancel'), [
                'class' => 'w3-btn w3-black w3-left w3-margin-right'], route('user.index')) !!}
            {{ Form::button(__('forms.global.save_edits'), [
                'class' => 'w3-btn w3-black w3-right w3-margin-left',
                'type'  => 'submit']) }}
        </p>

    {!! Form::close() !!}
@stop
