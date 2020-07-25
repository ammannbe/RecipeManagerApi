<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Ingredients\Food;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Food::class, function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\de_AT\Restaurant(($faker)));

    return [
        'name' => $faker->unique()->foodName(),
    ];
});
