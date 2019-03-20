<?php

use App\Models\Address;
use App\Models\Mission;
use App\Models\Project;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Mission::class, function (Faker $faker) {
    return [
        'project_id'    => factory(Project::class),
        'address_id'    => factory(Address::class),
        'is_locked'     => false,
        'title'         => $faker->text(10),
        'description'   => $faker->text($faker->numberBetween(5, 200)),
        'start_at'      => Carbon::now()->addMonth()->toDateTimeString(),
        'duration'      => $faker->numberBetween(1, 15),
        'capacity'      => $faker->numberBetween(1, 10),
    ];
});

$factory->state(Mission::class, 'locked', function (Faker $faker) {
    return [
        'is_locked' => true,
    ];
});

$factory->state(Mission::class, 'past', function (Faker $faker) {
    return [
        'start_at' => Carbon::now()->subMonth()->toDateTimeString(),
    ];
});

