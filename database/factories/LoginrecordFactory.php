<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Loginrecord::class, function (Faker $faker) {
        $ca=$faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
    return [
        'name' => $faker->randomElement($array = array ('keke','xixi','haha','momo','dada','gaga')),
        'created_at' =>$ca,
        'updated_at' =>$ca
    ];
});
