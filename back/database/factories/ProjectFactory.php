<?php

use App\Models\Client;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $steps = Project::steps();

    return [
        'client_id'         => factory(Client::class),
        'name'              => $faker->colorName . $faker->randomLetter,
        'step'              => $steps[$faker->numberBetween(0, count($steps) - 1)],
        'start_at'          => $faker->dateTime(),
        'is_private'        => false,
        'money_received_at' => $faker->dateTime(),
    ];
});
