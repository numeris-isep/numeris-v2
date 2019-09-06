<?php

use App\Models\Address;
use App\Models\Client;
use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Client::class, function (Faker $faker) {
    return [
        'address_id'    => factory(Address::class),
        'contact_id'    => factory(Contact::class),
        'name'          => $faker->company  . $faker->randomLetter . $faker->randomDigit * $faker->randomDigit
    ];
});
