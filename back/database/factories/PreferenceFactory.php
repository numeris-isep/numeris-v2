<?php

use App\Models\Preference;
use Faker\Generator as Faker;

$factory->define(Preference::class, function (Faker $faker) {
    return [
        'on_new_mission'    => $faker->numberBetween(0, 1),
        'on_acceptance'     => $faker->numberBetween(0, 1),
        'on_refusal'        => $faker->numberBetween(0, 1),
    ];
});

$factory->state(Preference::class, 'all_notifications', function () {
    return [
        'on_new_mission'    => 1,
        'on_acceptance'     => 1,
        'on_refusal'        => 1,
    ];
});

$factory->state(Preference::class, 'no_notifications', function () {
    return [
        'on_new_mission'    => 0,
        'on_acceptance'     => 0,
        'on_refusal'        => 0,
    ];
});
