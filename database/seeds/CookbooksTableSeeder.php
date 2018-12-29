<?php

use Illuminate\Database\Seeder;
use App\Cookbook;

class CookbooksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cookbook::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Cookbook::create([
                'name'      => $faker->firstName,
                'user_id'   => 50-$i,
            ]);
        }
    }
}
