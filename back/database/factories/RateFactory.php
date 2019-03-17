<?php

use App\Models\Convention;
use App\Models\Rate;
use Faker\Generator as Faker;

$factory->define(Rate::class, function (Faker $faker) {
    $rate = $faker->numberBetween(10, 20);

    return [
        'convention_id' => factory(Convention::class),
        'name'          => 'Heures ' . $faker->colorName,
        'is_flat'       => 0,
        'hours'         => null,
        'for_student'       => $rate,
        'for_staff'         => $rate + $rate * 0.2,
        'for_client'        => $rate + $rate * 0.4,
    ];
});

$factory->state(Rate::class, 'flat-rate', function (Faker $faker) {
    $hours = [3.5, 7, 9][$faker->numberBetween(0, 2)];
    $rate = $faker->numberBetween(10, 20) * $hours;

    return [
        'convention_id' => factory(Convention::class),
        'name'          => "Forfait {$hours}h",
        'is_flat'       => 1,
        'hours'         => $hours,
        'for_student'       => $rate,
        'for_staff'         => $rate + $rate * 0.2,
        'for_client'        => $rate + $rate * 0.4,
    ];
});
