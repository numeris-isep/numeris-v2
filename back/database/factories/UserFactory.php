<?php

use App\Models\Address;
use App\Models\Preference;
use App\Models\User;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {
    return [
        'email'     => $faker->unique()->safeEmail,
        'password'  => bcrypt('azerty'),
    ];
});

$factory->state(User::class, 'inactive', function () {
    return [];
});

$factory->state(User::class, 'active', function (Faker $faker) {
    return [
        'preference_id'             => factory(Preference::class)->create(),
        'address_id'                => factory(Address::class)->create(),
        'activated'                 => true,
        'tou_accepted'              => true,
        'membership_fee_paid'       => true,
        'username'                  => $faker->unique()->userName,
        'first_name'                => $faker->firstName,
        'last_name'                 => $faker->lastName,
        'student_number'            => $faker->numberBetween(1000, 99999),
        'promotion'                 => $faker->year('now'),
        'phone'                     => $faker->phoneNumber,
        'nationality'               => 'Français',
        'birth_date'                => $faker->dateTime,
        'birth_city'                => $faker->city,
        'social_insurance_number'   => $faker->numberBetween(1000000000000, 1999999999999),
        'iban'                      => strtoupper($faker->text(15)),
        'bic'                       => $faker->swiftBicNumber,
    ];
});
