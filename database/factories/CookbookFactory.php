<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use App\Models\Users\Author;
use Faker\Generator as Faker;
use App\Models\Recipes\Cookbook;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Cookbook::class, function (Faker $faker) {
    $userId = $faker->randomElement(User::pluck('id')->toArray());

    return [
        'name' => $faker->unique(true)->word,
        'user_id' => $userId,
        'author_id' => Author::firstWhere('user_id', $userId),
    ];
});
