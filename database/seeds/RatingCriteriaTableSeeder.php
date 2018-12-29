<?php

use Illuminate\Database\Seeder;
use App\RatingCriterion;

class RatingCriteriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        RatingCriterion::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            RatingCriterion::create([
                'name' => $faker->firstName,
            ]);
        }
    }
}
