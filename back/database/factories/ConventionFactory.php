<?php

use App\Models\Client;
use App\Models\Convention;
use Faker\Generator as Faker;

$factory->define(Convention::class, function (Faker $faker) {
    return [
        'name'      => (string) $faker->numberBetween(10, 99) . '-' . (string) $faker->numberBetween(1000, 9999),
    ];
});

$factory->state(Convention::class, 'with-client', function (Faker $faker) {
    return [
        'client_id' => factory(Client::class)->create(),
        'name'      => (string) $faker->numberBetween(10, 99) . '-' . (string) $faker->numberBetween(1000, 9999),
    ];
});
