<?php

use Illuminate\Database\Seeder;
use App\Models\Ingredients\IngredientAttribute;

class IngredientAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IngredientAttribute::factory()->times(30)->create();
    }
}
