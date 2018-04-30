<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Trace::class, function (Faker $faker) {
  $createtime=$faker->dateTimeBetween($startDate = '-3 months', $endDate = 'now');
  $name=$faker->randomElement($array = array ('keke','xixi','haha','momo','dada','gaga'));
    return [
        'type' =>$faker->randomElement(["结算","决算"]),
        'name' => $name,
        'content' => $name.'于'.$createtime->format("Y-m-d H:i:s").$faker->randomElement(["新建了","修改了","删除了"]).'订单编号为'.str_random(9).'的订单',
        'created_at' =>$createtime,
        'year'=>$createtime->format('Y'),
        'month'=>$createtime->format('m'),
    ];
});
