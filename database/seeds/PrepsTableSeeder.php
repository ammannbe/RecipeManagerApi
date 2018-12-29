<?php

use Illuminate\Database\Seeder;
use App\Prep;

class PrepsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Prep::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Prep::create([
                'name' => $faker->firstName,
            ]);
        }
    }
}
