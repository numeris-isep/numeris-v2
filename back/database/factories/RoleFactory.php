<?php

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'      => Role::STUDENT,
        'name_fr'   => 'Étudiant',
        'hierarchy' => 4,
    ];
});
