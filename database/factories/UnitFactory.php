<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Ingredients\Unit;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Unit::class, function (Faker $faker) {
    $name = $faker->unique()->word;
    $nameShortcut = substr($name, 0, -2);
    $namePlural = \Str::plural($name);
    $namePluralShortcut = substr($namePlural, 0, -2);

    return [
        'name' => $name,
        'name_shortcut' => $nameShortcut ? $nameShortcut : null,
        'name_plural' => $namePlural,
        'name_plural_shortcut' => $namePluralShortcut ? $namePluralShortcut : null,
    ];
});
