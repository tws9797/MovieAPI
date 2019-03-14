<?php

use Faker\Generator as Faker;

$factory->define(App\Model\Director::class, function (Faker $faker) {
    return [
      'name' => $faker->name,
    ];
});
