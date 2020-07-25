<?php

use Illuminate\Database\Seeder;
use App\Models\Ingredients\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Unit::class, 20)->create();
    }
}
