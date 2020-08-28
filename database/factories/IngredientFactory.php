<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Recipes\Recipe;
use App\Models\Ingredients\Food;
use App\Models\Ingredients\Unit;
use App\Models\Ingredients\Ingredient;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Ingredient::class, function (Faker $faker) {
    $recipeIds = Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->pluck('id')->toArray();
    $recipeId = (int) $faker->randomElement($recipeIds);
    $recipe = Recipe::withoutGlobalScope('isAdminOrOwnOrPublic')->find($recipeId);

    $amount = $faker->randomElement([null, $faker->randomFloat(2, 0, 999)]);
    $amountMax = null;
    if ($amount !== null) {
        $amountMax = $faker->randomFloat(2, $amount, 1000);
    }

    return [
        'recipe_id' => $recipe->id,
        'amount' => $amount,
        'amount_max' => $amountMax,
        'unit_id' => $faker->randomElement([null, ...Unit::pluck('id')->toArray()]),
        'food_id' => $faker->randomElement(Food::pluck('id')->toArray()),
        'ingredient_group_id' => $faker->randomElement([null, ...$recipe->ingredientGroups()->pluck('id')->toArray()]),
    ];
});
