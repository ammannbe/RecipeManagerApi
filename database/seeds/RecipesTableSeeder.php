<?php

use Illuminate\Database\Seeder;
use App\Recipe;

class RecipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Recipe::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Recipe::create([
                'cookbook_id'       => rand(0, 50),
                'author_id'         => rand(0, 50),
                'name'              => $faker->firstName,
                'yield_amount'      => rand(0, 999),
                'instructions'      => $faker->text(1000),
                'photo'             => file_get_contents('public/logo.png'),
                'preparation_time'  => $faker->time,
            ]);
        }
    }
}
