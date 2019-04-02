<?php

use App\Models\Client;
use App\Models\Convention;
use Faker\Generator as Faker;

$factory->define(Convention::class, function (Faker $faker) {
    return [
        'name' => 'Convention ' . $faker->colorName,
    ];
});

$factory->state(Convention::class, 'with-client', function (Faker $faker) {
    return [
        'client_id' => factory(Client::class)->create(),
    ];
});
