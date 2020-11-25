<?php

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

$factory->define('App\User', function (Faker $faker) {
    $name = $faker->firstName.' '.$faker->lastName;
    return [
        'name'       => $name,
        'first_name' => explode(' ', $name)[0],
        'last_name'  => explode(' ', $name)[1],
        'email'      => $faker->unique()->safeEmail,
        'role'       => ['advisor', 'staff', 'student'][rand(0, 2)],
        'password'   => '$2y$10$IsRRLbbiM6mNkZftaBuqyeOHFvIar.OKySyFLVTd3hCMWZAO.WvqS'
    ];
});
