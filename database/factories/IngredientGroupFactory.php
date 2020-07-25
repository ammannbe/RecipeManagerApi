<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Recipes\Recipe;
use App\Models\Ingredients\IngredientGroup;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(IngredientGroup::class, function (Faker $faker) {
    $recipeIds = Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->pluck('id')->toArray();

    return [
        'recipe_id' => $faker->randomElement($recipeIds),
        'name' => $faker->unique(true)->word,
    ];
});
