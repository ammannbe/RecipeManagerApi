<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;
use App\Models\Recipes\Category;

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(Category::class, function (Faker $faker) {
    $faker->addProvider(new \FakerRestaurant\Provider\de_AT\Restaurant(($faker)));

    $categories = [
        'Apéros',
        'Brotaufstrich',
        'Brote',
        'Brotspeisen',
        'Cakes, Kuchen, Torten (süss)',
        'Cremen, Desserts, Eis, Puddinge',
        'Eierspeisen',
        'Eingemachtes',
        'Fleischgerichte',
        'Getränke',
        'Guetsli, Kleingebäck, Pâtisserie',
        'Saucen',
        'Sirup',
        'Suppen',
        'Süsse Gerichte',
        'Teigwarengerichte',
        'Vegetarisch',
    ];

    return [
        'name' => $faker->unique()->randomElement($categories),
    ];
});
