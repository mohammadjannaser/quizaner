<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\EnrolledUser;
use App\Model\User;
use App\Model\Test;
use Faker\Generator as Faker;

$factory->define(EnrolledUser::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'test_id' => Test::all()->random()->id
    ];
});
