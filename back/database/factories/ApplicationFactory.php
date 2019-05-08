<?php

use App\Models\Application;
use App\Models\Mission;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Application::class, function (Faker $faker) {
    $types = Application::types();
    $statuses = Application::statuses();

    return [
        'user_id'       => factory(User::class),
        'mission_id'    => factory(Mission::class),
        'type'          => $types[$faker->numberBetween(0, count($types) - 1)],
        'status'        => $statuses[$faker->numberBetween(0, count($statuses) - 1)],
    ];
});
