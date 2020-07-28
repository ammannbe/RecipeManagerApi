<?php

use Illuminate\Database\Seeder;
use App\Models\Ingredients\IngredientGroup;

class IngredientGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(IngredientGroup::class, 40)->create();
    }
}
