<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Contact::class, function (Faker $faker) {
    return [
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'email'         => $faker->unique()->safeEmail,
        'phone'         => "0" . (string) $faker->numberBetween(600000000, 699999999),
    ];
});
