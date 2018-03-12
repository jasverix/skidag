<?php

use Faker\Generator as Faker;

/** @var Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Result::class, function (Faker $faker) {
  return [
    'name' => $faker->name,
    'age' => $faker->numberBetween(3, 18),
    'gender' => $faker->numberBetween(0, 1),
    'type' => $faker->randomElement([
      'Langrenn', 'Hopp', 'Skiskyting',
    ]),
    'seconds' => $faker->numberBetween(9.5, 19.5),
  ];
});
