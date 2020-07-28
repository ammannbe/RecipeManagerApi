<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\Author;
use Faker\Generator as Faker;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Author::class, function (Faker $faker) {
    return [
        // The user_id will be set through the UserSeeder
        'name' => $faker->unique(true)->name,
    ];
});
