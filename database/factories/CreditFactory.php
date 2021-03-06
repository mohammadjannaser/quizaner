<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Credit;
use Faker\Generator as Faker;

$factory->define(Credit::class, function (Faker $faker) {
    return [
        'credit_amount' => $faker->numberBetween(0,100) 
    ];
});
