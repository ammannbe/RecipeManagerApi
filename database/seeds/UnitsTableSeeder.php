<?php

use Illuminate\Database\Seeder;
use App\Unit;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unit::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            Unit::create([
                'name'                  => $faker->firstName,
                'name_shortcut'         => $faker->firstName,
                'name_plural'           => $faker->firstName,
                'name_plural_shortcut'  => $faker->firstName,
            ]);
        }
    }
}
