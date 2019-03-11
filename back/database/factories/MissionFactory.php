<?php

use App\Models\Address;
use App\Models\Mission;
use Faker\Generator as Faker;

$factory->define(Mission::class, function (Faker $faker) {
    return [
        'address_id'       => factory(Address::class),
        'title'         => $faker->text(10),
        'description'   => $faker->text($faker->numberBetween(5, 200)),
        'start_at'      => $faker->dateTime(),
        'duration'      => $faker->numberBetween(1, 15),
        'capacity'      => $faker->numberBetween(1, 10),
    ];
});
