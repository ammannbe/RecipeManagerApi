<?php

use Illuminate\Database\Seeder;
use App\IngredientDetail;

class IngredientDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        IngredientDetail::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            IngredientDetail::create([
                'recipe_id'             => rand(0, 50),
                'amount'                => rand(0, 999),
                'unit_id'               => rand(0, 50),
                'ingredient_id'         => rand(0, 50),
                'prep_id'               => rand(0, 50),
                'position'              => rand(0, 10),
            ]);
        }
    }
}
