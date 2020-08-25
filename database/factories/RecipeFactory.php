<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use Faker\Generator as Faker;
use App\Models\Recipes\Recipe;
use App\Models\Recipes\Category;
use App\Models\Recipes\Cookbook;
use App\Models\Users\AdminOrOwnerScope;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Recipe::class, function (Faker $faker) {
    $cookbookIds = Cookbook::withoutGlobalScope(AdminOrOwnerScope::class)->pluck('id')->toArray();
    $cookbookId = (int) $faker->randomElement([null, ...$cookbookIds]);
    if ($cookbookId) {
        $cookbook = Cookbook::withoutGlobalScope(AdminOrOwnerScope::class)->find($cookbookId);
        $user = User::find($cookbook->user_id);
    } else {
        $cookbookId = null;
        $userId = (int) $faker->randomElement(User::pluck('id')->toArray());
        $user = User::find($userId);
    }

    return [
        'user_id' => $user->id,
        'cookbook_id' => $cookbookId,
        'category_id' => $faker->randomElement(Category::pluck('id')->toArray()),
        'author_id' => $user->author->id,
        'name' => $faker->unique(true)->name . ' ' . $faker->foodName(),
        'yield_amount' => $faker->randomElement([null, $faker->numberBetween(0, 30)]),
        'complexity' => $faker->randomElement(Recipe::COMPLEXITY_TYPES),
        'instructions' => $faker->unique(true)->text,
        'photos' => null,
        'preparation_time' => $faker->randomElement([null, $faker->time('H:i:00', '24:59')]),
    ];
});
