<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 50; $i++) {
            User::create([
                'name'              => $faker->name,
                'email'             => $faker->email,
                'email_verified_at' => $faker->dateTime,
                'password'          => $faker->password,
                'api_token'         => str_random(60),
            ]);
        }
    }
}
