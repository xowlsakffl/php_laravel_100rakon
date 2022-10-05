<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'order_number' => $faker->date,
        'udx' => $user = User::all()->random()->udx,
        'total_amount' => $total = $faker->numberBetween(10000, 100000),
        'use_point' => 0,
        'pay_amount' => $total,
        'pay_kind' => $faker->randomElement(['무통장', '카드', '핸드폰', '가상계좌']),
        'pay_name' => $faker->name,
        'pay_tel' => User::find($user)->cell,
        'delivery_zipcode' => $faker->postcode,
        'delivery_address1' => $faker->address,
        'delivery_address2' => $faker->streetName,
        'delivery_name' => $faker->name,
        'delivery_tel' => $faker->phoneNumber,
        'delivery_msg' => $faker->paragraph,
        'receipt_kind' => $faker->randomElement(['세금계산서', '현금영수증']),
        'company_regist_number' => "000-00-00000",
        'company_name' => $faker->name,
        'company_president_name' => $faker->name,
        'company_kind1' => $faker->name,
        'company_kind2' => $faker->name,
        'company_charge_email' => $faker->email,
        'person_name' => $faker->name,
        'person_unique_number' => $faker->phoneNumber,
        'state' => 10
    ];
});
