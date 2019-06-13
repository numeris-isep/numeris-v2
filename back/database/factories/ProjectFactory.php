<?php

use App\Models\Client;
use App\Models\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    $steps = Project::steps();

    return [
        'client_id'         => factory(Client::class),
        'name'              => $faker->colorName . $faker->randomLetter . $faker->randomDigit * $faker->randomDigit,
        'step'              => $steps[$faker->numberBetween(0, count($steps) - 1)],
        'start_at'          => $faker->dateTime(),
        'is_private'        => false,
        'money_received_at' => $faker->dateTime(),
    ];
});

$factory->state(Project::class, 'private', function() {
    return ['is_private' => true];
});

$factory->state(Project::class, Project::HIRING, function() {
    return ['step' => Project::HIRING];
});

$factory->state(Project::class, Project::VALIDATED, function() {
    return ['step' => Project::VALIDATED];
});

$factory->state(Project::class, Project::BILLED, function() {
    return ['step' => Project::BILLED];
});

$factory->state(Project::class, Project::PAID, function() {
    return ['step' => Project::PAID];
});

$factory->state(Project::class, Project::CLOSED, function() {
    return ['step' => Project::CLOSED];
});
