<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Friend;
use App\Model\StudentUser;

use Faker\Generator as Faker;

$factory->define(Friend::class, function (Faker $faker) {
    return [
        'user1_id' => StudentUser::all()->random()->user_id,
        'user2_id' => StudentUser::all()->random()->user_id,
    ];
});
