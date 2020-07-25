<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use Faker\Generator as Faker;
use App\Models\Ratings\Rating;
use App\Models\Recipes\Recipe;
use App\Models\Ratings\RatingCriterion;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Rating::class, function (Faker $faker) {
    $recipeIds = Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->pluck('id')->toArray();

    return [
        'recipe_id' => $faker->randomElement($recipeIds),
        'user_id' => $faker->randomElement([null, ...User::pluck('id')->toArray()]),
        'rating_criterion_id' => $faker->randomElement(RatingCriterion::pluck('id')->toArray()),
        'comment' => $faker->text,
        'stars' => $faker->randomElement([null, $faker->randomDigit()]),
    ];
});
