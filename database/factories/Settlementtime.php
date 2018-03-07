<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Settlementtime::class, function (Faker $faker) {
  $finished_ordernum=$faker->randomDigitNotNull;
    return [
        'finished_ordernum' => $finished_ordernum,
        'finished_projectnum' => $faker->numberBetween(0, $finished_ordernum),
        'created_at' =>$faker->dateTimeThisMonth(),
        'updated_at' =>$faker->dateTimeThisMonth()
    ];
});
