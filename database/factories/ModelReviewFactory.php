<?php

use Faker\Generator as Faker;
use App\Model\Movie;
use App\User;

$factory->define(App\Model\Review::class, function (Faker $faker) {
    return [
      'movie_id' => function(){
        return Movie::all()->random();
      },
      'user_id' => function(){
        return User::all()->random();
      },
      'review' => $faker->paragraph,
      'star' => $faker->numberBetween(0,5),
    ];
});
