<?php

use Faker\Generator as Faker;
use App\Model\Director;

$factory->define(App\Model\Movie::class, function (Faker $faker) {
    return [
      'name' => $faker->word,
      'plot' => $faker->paragraph,
      'year' => $faker->year($max = 'now'),
      'director_id' => function(){
        return Director::all()->random();
      },
    ];
});
