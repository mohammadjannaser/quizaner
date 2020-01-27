<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Follower;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Follower::class, function (Faker $faker) {
    return [
        /****
         * user1_id
         * user2_id
         */
 
        'user1_id' => User::all()->random()->id,
        'user2_id' => User::all()->random()->id
    ];
});
