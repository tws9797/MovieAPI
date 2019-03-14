<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Actor::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
    ];
});
