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
        'preference_id' => factory(Preference::class)->state('all-notifications'),
        'address_id'    => factory(Address::class),
        'email'         => strtolower($faker->firstName . $faker->randomDigit * $faker->randomDigit  * $faker->randomDigit  * $faker->randomDigit . '@isep.fr'),
        'password'      => bcrypt('azertyuiop'),
        'first_name'    => $faker->firstName,
        'last_name'     => $faker->lastName,
        'promotion'     => $faker->numberBetween(now()->year, now()->addYears(5)->year),
        'birth_date'    => $faker->dateTime,
    ];
});

$factory->state(User::class, 'inactive', function () {
    return [
        'activated'         => false,
        'tou_accepted'      => false,
        'email_verified_at' => null,
    ];
});

$factory->state(User::class, 'active', function (Faker $faker) {
    return [
        'activated'                 => true,
        'tou_accepted'              => true,
        'email_verified_at'         => $faker->dateTime,
        'subscription_dates'        => null,
        'phone'                     => '0' . (string) $faker->numberBetween(600000000, 699999999),
        'nationality'               => 'france',
        'birth_city'                => $faker->city,
        'social_insurance_number'   => $faker->numberBetween(100000000000000, 199999999999999),
        'iban'                      => mb_strtoupper($faker->lexify('???????????????'), 'UTF-8'),
        'bic'                       => $faker->bothify('#??##?#?'),
    ];
});

$factory->state(User::class, 'no-notification', function () {
    return [
        'preference_id' => factory(Preference::class)->state('no-notification'),
    ];
});
