<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Rreturntime::class, function (Faker $faker) {

    return [
        '不具备决算送审条件' => $faker->randomDigitNotNull,
        '具备送审条件未送审' => $faker->randomDigitNotNull,
        '被退回' => $faker->randomDigitNotNull,
        '审计中' => $faker->randomDigitNotNull,
        '已出报告' => $faker->randomDigitNotNull,
        'created_at' =>$faker->dateTimeThisMonth(),
        'updated_at' =>$faker->dateTimeThisMonth()
    ];
});
