<?php

use App\Models\Client;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $steps = Project::steps();

    return [
        'name'              => $faker->colorName,
        'step'              => $steps[$faker->numberBetween(0, count($steps) - 1)],
        'start_at'          => $faker->dateTime(),
        'is_private'        => false,
        'money_received_at' => $faker->dateTime(),
    ];
});

$factory->state(Project::class, 'with-client', function (Faker $faker) {
    $steps = Project::steps();

    return [
        'client_id'         => factory(Client::class)->create(),
        'name'              => $faker->colorName,
        'step'              => $steps[$faker->numberBetween(0, count($steps) - 1)],
        'start_at'          => $faker->dateTime(),
        'is_private'        => false,
        'money_received_at' => $faker->dateTime(),
    ];
});
