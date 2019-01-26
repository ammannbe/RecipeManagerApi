@extends('layouts.master')


@section('title', 'E-Mail bestätigen')


@section('content-class', 'verify')
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
    @php(\Toast::success('Neuer Link wurde versendet.'))
@endif
