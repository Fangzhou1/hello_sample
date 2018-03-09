<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Trace::class, function (Faker $faker) {
  $createtime=$faker->dateTimeThisDecade();

    return [
        'type' =>$faker->randomElement(["结算","决算"]),
        'content' => $faker->name.'于'.$createtime->format("Y-m-d H:i:s").$faker->randomElement(["新建了","修改了","删除了"]).'订单编号为'.str_random(9).'的订单',
        'created_at' =>$createtime,
        'year'=>$createtime->format('Y'),
        'month'=>$createtime->format('m'),
    ];
});
