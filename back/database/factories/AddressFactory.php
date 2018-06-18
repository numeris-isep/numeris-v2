<?php

use App\Models\Address;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'street'    => $faker->streetAddress,
        'postcode'  => $faker->numberBetween(10000, 99999),
        'city'      => $faker->city,
    ];
});
