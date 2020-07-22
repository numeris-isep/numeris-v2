<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
      'title'   => $faker->text(10),
      'content' => $faker->sentence,
      'link'    => $faker->url,
      'is_active' => false,
    ];
});

$factory->state(Message::class, 'inactive', function () {
    return [
        'is_active'         => false,
    ];
});

$factory->state(Message::class, 'active', function () {
    return [
        'is_active'         => true,
    ];
});
