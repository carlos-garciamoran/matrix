<?php

use Faker\Generator as Faker;

$factory->define('App\Student', function (Faker $faker) {
    return [
        'user_id' => function() {
            return factory('App\User')->create(['role' => 'S'])->id;
        },
        'country'   => $faker->word,
        'grade'     => rand(10, 12),
        'residence' => rand(1, 4),
        'house'     => [10, 11, 12, 14, 15, 20][rand(0, 5)],
        'room'      => $faker->regexify('[A-F]{1}')
    ];
});
