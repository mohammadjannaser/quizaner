<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\InrolledUser;
use App\Model\User;
use App\Model\Test;
use Faker\Generator as Faker;

$factory->define(InrolledUser::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'test_id' => Test::all()->random()->id
    ];
});
