<?php

use App\Models\Application;
use App\Models\Bill;
use App\Models\Rate;
use Faker\Generator as Faker;

$factory->define(Bill::class, function (Faker $faker) {
    return [
        'application_id'    => factory(Application::class),
        'rate_id'           => factory(Rate::class),
        'amount'            => $faker->numberBetween(0.5, 10),
    ];
});
