<?php

use Illuminate\Database\Seeder;
use App\Models\Ratings\RatingCriterion;

class RatingCriterionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(RatingCriterion::class, 50)->create();
    }
}
