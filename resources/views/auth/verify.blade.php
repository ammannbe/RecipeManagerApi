@extends('layouts.master')


@section('title', 'E-Mail bestätigen')


@section('class', 'verify')
@section('content')
    <article>
        <h1>Bitte bestätige deine E-Mail Adresse</h1>
        <p>
            Befor du vortfährst, prüfe deine E-Mails auf einen Bestätigungs-Link.<br>
            Falls du keinen erhalten hast, <a href="{{ route('verification.resend') }}">klicke hier um einen neuen anzufordern</a>.
        </p>
    </article>
@endsection


@if (session('resent'))
    <div class="toast">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            Neuer Link wurde versendet.
        </div>
    </div>
@endif
