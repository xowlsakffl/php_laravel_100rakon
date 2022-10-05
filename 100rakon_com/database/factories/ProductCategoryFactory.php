<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    return [
        'sequence' => 0,
        'cname' => '식음료',
        'parent' => $faker->numberBetween(1, 10),
        'state' => 10,
    ];
});
