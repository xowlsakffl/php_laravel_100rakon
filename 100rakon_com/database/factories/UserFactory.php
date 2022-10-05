<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(User::class, function (Faker $faker) {
    return [       
        'email' => $faker->unique()->safeEmail,      
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'name' => $faker->name,
        'email_auth' => 'N',
        'email_verified_at' => now(),
        'cell' => $faker->phoneNumber,
        'cell_auth' => 'N',
        'cell_authed_at' => now(),
        'tel' => $faker->phoneNumber,
        'join_from' => 'home',
        'super' => 'N',
        'state' => 10,
        'personal_agree' => 'Y',
        'remember_token' => Str::random(10),
    ];
});
