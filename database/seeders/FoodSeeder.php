<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ingredients\Food;

class FoodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Food::factory()->times(20)->create();
    }
}
