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
        window.Laravel = {
            isLoggedIn: false,
            hasVerifiedEmail: false,
            user: {
                name: "-",
                email: "-",
                admin: false,
                created_at: new Date().toJSON(),
                updated_at: new Date().toJSON()
            }
        }
    </script>
@endif

<script src="{{ mix('js/app.js') }}" defer></script>
