@extends('layouts.master')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1>Dashboard</h1>

                <div class="card-body">
                    <span>Name: {{ Auth::User()->name }}</span><br>
                    <span>E-Mail: {{ Auth::User()->email }}</span><br>
                    <span>Registriert: {{ FormatHelper::date(Auth::User()->created_at) }}</span><br>
                    <br>
                    <a href="/user/edit">Profil bearbeiten<i class="pencil"></i></a><br>
                    <br>

                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Du bist eingeloggt!
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
