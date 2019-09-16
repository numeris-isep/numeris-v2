<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Payslip;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Payslip::class, function (Faker $faker) {
    return [
        'user_id'                      => factory(User::class),
        'month'                     => Carbon::now()->addMonth()->toDateTimeString(),
        'hour_amount'               => 10.00,
        'gross_amount'              => 100.00,
        'net_amount'                => 80.00,
        'final_amount'              => 62.00,
        'subscription_fee'          => 18.00,
        'deduction_amount'          => 20.00,
        'employer_deduction_amount' => 30.00,
        'deductions'                => json_encode([[
            'socialContribution'    => 'Contribution',
            'base'                  => 100.00,
            'employeeRate'          => 20,
            'employerRate'          => 30,
            'employeeAmount'        => 20,
            'employerAmount'        => 30,
        ]]),
        'operations'                => json_encode([[
            'id'                    => 1,
            'reference'             => $faker->numberBetween(10, 99)
            . '-' . $faker->numberBetween(1000, 9999)
            . '-' . strtoupper(substr(sha1($faker->numberBetween(10, 99)), 0, 4)),
            'startAt'               => Carbon::now()->addMonth()->toDateTimeString(),
        ]]),
        'clients'                   => json_encode([[
            'id'                    => 1,
            'name'                  => 'Client de test',
        ]]),
    ];
});
