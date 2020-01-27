<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Friend;
use App\Model\User;

use Faker\Generator as Faker;

$factory->define(Friend::class, function (Faker $faker) {
    return [
        'user1_id' => User::all()->random()->id,
        'user2_id' => User::all()->random()->id,
    ];
});
