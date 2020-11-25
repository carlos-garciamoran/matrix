<?php

use Faker\Generator as Faker;

$factory->define('App\Advisor', function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create(['role' => 'A'])->id;
        },
        'duty'  => rand(0, 1),
        'title' => ['Mr', 'Ms', 'Mrs', 'Dr'][rand(0, 3)]
    ];
});
