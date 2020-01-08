<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\InrolledUser;
use App\Model\StudentUser;
use App\Model\Test;
use Faker\Generator as Faker;

$factory->define(InrolledUser::class, function (Faker $faker) {
    return [
        'user_id' => StudentUser::all()->random()->user_id,
        'test_id' => Test::all()->random()->id
    ];
});
