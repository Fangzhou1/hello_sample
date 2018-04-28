<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Loginrecord::class, function (Faker $faker) {

    return [
        'name' => $faker->randomElement($array = array ('keke','xixi','haha','momo','dada','gaga')),
        'created_at' =>$faker->dateTimeThisMonth(),
        'updated_at' =>$faker->dateTimeThisMonth()
    ];
});
