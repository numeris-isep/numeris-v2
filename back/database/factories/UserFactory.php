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
        'preference_id' => factory(Preference::class)->create(),
        'address_id'    => factory(Address::class)->create(),
        'email'         => $faker->firstName . $faker->randomDigit * $faker->randomDigit . '@isep.fr',
        'password'      => bcrypt('azerty'),
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'promotion'     => $faker->numberBetween(2015, 2025),
        'birth_date'    => $faker->dateTime,
    ];
});

$factory->state(User::class, 'inactive', function () {
    return [
        'activated'     => false,
        'tou_accepted'  => false,
    ];
});

$factory->state(User::class, 'active', function (Faker $faker) {
    return [
        'activated'                 => true,
        'tou_accepted'              => true,
        'subscription_paid_at'      => $faker->dateTime(),
        'phone'                     => '0' . (string) $faker->numberBetween(600000000, 699999999),
        'nationality'               => 'france',
        'birth_city'                => $faker->city,
        'social_insurance_number'   => $faker->numberBetween(100000000000000, 199999999999999),
        'iban'                      => strtoupper($faker->asciify('***************')),
        'bic'                       => $faker->swiftBicNumber,
    ];
});
