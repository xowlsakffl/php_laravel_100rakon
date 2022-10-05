<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use App\OrderItem;
use App\Product;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'odx' => $order = Order::all()->random()->odx,
        'pdx' => $product = Product::all()->random()->pdx,
        'price' => $price = $faker->numberBetween(1000, 10000),
        'quantity' => $quantity = $faker->numberBetween(1, 10),
        'amount' => $price * $quantity,
        'delivery_origin_cost' => 2500,
        'delivery_kind' => $faker->randomElement(['선불', '착불', '무료']),
        'delivery_pay' => '0',
        'delivery_logistics' => $faker->randomElement(['대한통운', '롯데택배', '한진택배']),
        'delivery_serial' => $faker->randomDigit,
        'state' => 10,
    ];
});
