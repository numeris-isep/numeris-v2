<?php

use App\Models\SocialContribution;
use Faker\Generator as Faker;

$factory->define(SocialContribution::class, function (Faker $faker) {
    return [
        'name'          => $faker->colorName,
        'student_rate'  => $faker->randomFloat(2, 0, 15),
        'employer_rate' => $faker->randomFloat(2, 0, 15),
        'base'          => $faker->randomFloat(2, 0, 1),
    ];
});
