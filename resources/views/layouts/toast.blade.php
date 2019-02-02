{{-- Look for validation errors and save them to Toast --}}
@foreach ($errors->all() as $message)
    @php (\Toast::error($message))
@endforeach

{{-- If a Toast is found, print them and clear it --}}
@if(Session::has('toasts'))
    <div class="toast">
        @include('toast::messages')
    </div>

    @php(Toast::clear())
@endif
