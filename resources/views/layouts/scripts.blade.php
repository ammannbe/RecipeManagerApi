@if (Auth::check())
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedIn' => true,
            'hasVerifiedEmail' => Auth::user()->hasVerifiedEmail(),
            'user' => Auth::user()
        ])!!}
    </script>
@else
    <script>
        window.Laravel = {!!json_encode([
            'isLoggedIn' => false,
            'hasVerifiedEmail' => false
        ])!!}
    </script>
@endif

<script src="{{ mix('js/app.js') }}" defer></script>
