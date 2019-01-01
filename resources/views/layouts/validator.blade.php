@foreach ($errors->all() as $message)
    @php (\Toast::error($message))
@endforeach
