@php
use \Illuminate\Mail\Markdown;
@endphp

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $recipe->name }}</title>

        <link href="{{ public_path('css/pdf.css') }}" rel="stylesheet">
    </head>

    <body>

        <main>
            @if ($recipe->photo_paths)
            <img src="{{ $recipe->photo_paths[0] }}" alt="{{ $recipe->name }}">
            @endif

            <h1 class="title is-1">{{ $recipe->name }}</h1>

            <table>
                @if (
                    isset(config('app.disabled_controllers')['CookbookController'])
                    && $recipe->cookbook_id
                )
                <tr>
                    <th>@lang('Cookbook'):</th>
                    <td>{{ $recipe->cookbook->name }}</td>
                </tr>
                @endif

                @if ($recipe->author)
                <tr>
                    <th>@lang('Author'):</th>
                    <td>{{ $recipe->author->name }}</td>
                </tr>
                @endif

                <tr>
                    <th>@lang('Category'):</th>
                    <td>{{ $recipe->category->name }}</td>
                </tr>

                <tr>
                    <th>@lang('Yield amount'):</th>
                    <td>{{ $recipe->yield_amount }}</td>
                </tr>

                <tr>
                    <th>@lang('Complexity'):</th>
                    <td>{{ $recipe->complexity_text }}</td>
                </tr>

                @if ($recipe->preparation_time)
                <tr>
                    <th>@lang('Preparation time'):</th>
                    <td>{{ $recipe->preparation_time }}</td>
                </tr>
                @endif

                @if ($recipe->tags()->exists())
                <tr>
                    <th>@lang('Tags'):</th>
                    <td>{{ $recipe->tags()->pluck('name')->join(', ') }}</td>
                </tr>
                @endif
            </table>

            <h2>@lang('Ingredients')</h2>
            @if ($recipe->ingredients->whereNull('ingredient_group_id')->count())
                <ul>
                    @foreach ($recipe->ingredients->whereNull('ingredient_group_id') as $ingredient)
                    <li>{{ $ingredient->name }}</li>

                    @if ($ingredient->ingredients)
                        @foreach ($ingredient->ingredients as $alternate)
                            <li>{{ __('Or') }}: {{ $alternate->name }}</li>
                        @endforeach
                    @endif
                    @endforeach
                </ul>
            @endif

            @php
                $groups = $recipe
                    ->ingredients
                    ->where('ingredient_group_id', '!=', null)
                    ->groupBy('ingredient_group_id');
            @endphp
            @foreach ($groups as $grouped)
                <h3>{{ $grouped->first()->ingredientGroup->name }}</h3>
                <ul>
                    @foreach ($grouped as $ingredient)
                    <li>{{ $ingredient->name }}</li>
                    @endforeach
                </ul>
            @endforeach

            <h2>@lang('Instructions')</h2>
            <div>{!! Markdown::parse($recipe->instructions)->toHtml() !!}</div>
        </main>

        @include('layouts.footer')

        @include('layouts.scripts')
    </body>
</html>
