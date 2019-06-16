<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Faker\Generator as Faker;

$factory->define(UserRole::class, function (Faker $faker) {
    return [
        'role_id' => Role::find($faker->numberBetween(1, 4)),
        'user_id' => factory(User::class),
    ];
});
