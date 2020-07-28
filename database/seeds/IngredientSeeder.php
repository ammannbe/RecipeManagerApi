<?php

use App\Models\Ingredients\Ingredient;
use App\Models\Ingredients\IngredientAttribute;
use Illuminate\Database\Seeder;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Ingredient::class, 500)->create();

        $ingredientAttributes = IngredientAttribute::get();

        Ingredient::get()->each(function ($ingredient) use ($ingredientAttributes) {
            $random = $ingredientAttributes->random(rand(0, 3))->pluck('id');
            $ingredient->ingredientAttributes()->attach($random);
        });
    }
}
