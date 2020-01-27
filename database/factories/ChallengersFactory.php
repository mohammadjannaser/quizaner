<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Challengers;

use App\Model\User;

use App\Model\Test;

use Faker\Generator as Faker;

$factory->define(Challengers::class, function (Faker $faker) {
    return [
     
        'user1_id' => User::all()->random()->id,
        'user2_id' => User::all()->random()->id,
        'test_id' => Test::all()->random()->id
    ];
});
