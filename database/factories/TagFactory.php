<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Recipes\Tag;
use Faker\Generator as Faker;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
