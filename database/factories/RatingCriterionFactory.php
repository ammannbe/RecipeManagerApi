<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Ratings\RatingCriterion;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(RatingCriterion::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->word,
    ];
});
