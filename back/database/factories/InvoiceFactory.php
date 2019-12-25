<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Invoice;
use App\Models\Project;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'project_id'    => factory(Project::class),
        'gross_amount'  => 5000.00,
        'vat_amount'    => 1000.00,
        'final_amount'  => 6000.00,
        'time_limit'    => 30,
        'details'       => json_encode([[
            'bills'     => [[
                'rate'      => 'Heures de test',
                'hours'     => 100,
                'amount'    => 50,
                'total'     => 5000,
            ]],
            'title'     => 'Mission de test',
            'startAt'   => Carbon::now()->addMonth()->toDateTimeString(),
            'reference' => $faker->numberBetween(10, 99)
                . '-' . $faker->numberBetween(1000, 9999)
                . '-' . mb_strtoupper(substr(sha1($faker->numberBetween(10, 99)), 0, 4), 'UTF-8'),
        ]]),
    ];
});
