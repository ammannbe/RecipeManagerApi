<?php

use App\Models\Users\Author;
use App\Models\Users\User;
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
