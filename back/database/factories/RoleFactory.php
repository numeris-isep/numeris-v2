<?php

use App\Models\Role;
use Faker\Generator as Faker;

$factory->define(Role::class, function (Faker $faker) {
    return [
        'name'      => 'student',
        'name_fr'   => 'Étudiant',
        'hierarchy' => 4,
    ];
});
