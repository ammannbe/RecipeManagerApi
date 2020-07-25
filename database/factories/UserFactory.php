<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Users\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

if (!isset($factory)) {
    throw new \Exception('Factory is not defined');
}

$factory->define(User::class, function (Faker $faker) {
    return [
        'email' => $faker->unique(true)->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => \Str::random(10),
    ];
});
