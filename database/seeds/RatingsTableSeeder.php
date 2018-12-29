<?php

use Illuminate\Database\Seeder;
use App\Rating;

class RatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rating::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Rating::create([
                'recipe_id'             => $i+1,
                'user_id'               => 50-$i,
                'rating_criterion_id'   => rand(0, 50),
                'comment'               => $faker->text,
            ]);
        }
    }
}
