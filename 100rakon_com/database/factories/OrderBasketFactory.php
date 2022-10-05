<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\OrderBasket;
use App\Product;
use App\User;
use Faker\Generator as Faker;

$factory->define(OrderBasket::class, function (Faker $faker) {
    return [
        'udx' => $user = User::all()->random()->udx,
        'pdx' => $product = Product::all()->random()->pdx,
        'price' => $price = $faker->numberBetween(1000, 10000),
        'quantity' => $quantity = $faker->numberBetween(1, 10),
    ];
});
