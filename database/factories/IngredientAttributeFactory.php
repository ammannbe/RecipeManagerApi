<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Ingredients\IngredientAttribute;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(IngredientAttribute::class, function (Faker $faker) {
    $ingredientAttributes = [
        'gerieben',
        'schwarz',
        'gehackt',
        'weiss',
        'säuerlich',
        'gross',
        'gemahlen',
        'dunkel',
        'gewürfelt',
        'heiss',
        'geschnetzelt',
        'eingesotten',
        'gedörrt',
        'lauwarm',
        'grob',
        'geschält',
        'in Scheiben',
        'warm',
        'gehobelt',
        'reif',
        'fein geschnitten',
        'rund',
        'klein',
        'hell',
        'flüssig',
        'in Vierteln',
        'grob gehackt',
        'weich',
        'zartbitter',
        'instant',
        'kandiert',
        'fein gerieben',
        'ausgeschabt',
        'gekocht',
        'fein',
        '1 gr. od. 2 kl.',
        'leicht verklopft',
        'zum Bestäuben',
    ];

    return [
        'name' => $faker->unique()->randomElement($ingredientAttributes),
    ];
});
