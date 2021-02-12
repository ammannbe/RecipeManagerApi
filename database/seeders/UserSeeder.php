<?php

namespace Database\Seeders;

use App\Models\Users\User;
use App\Models\Users\Author;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->times(50)->create()->each(function ($user) {
            $user->author()->save(Author::factory()->make());
        });
    }
}
