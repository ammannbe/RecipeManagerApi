<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredients\Ingredient;
use App\Models\Ingredients\IngredientAttribute;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ingredientAttributes = IngredientAttribute::get();
        Ingredient::factory()->times(500)->create()->each(function ($ingredient) use ($ingredientAttributes) {
            $random = $ingredientAttributes->random(rand(0, 3))->pluck('id');
            $ingredient->ingredientAttributes()->attach($random);
        });
    }
}
