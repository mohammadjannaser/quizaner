<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Challengers;

use App\Model\StudentUser;

use App\Model\Test;

use Faker\Generator as Faker;

$factory->define(Challengers::class, function (Faker $faker) {
    return [
     
        'user1_id' => StudentUser::all()->random()->user_id,
        'user2_id' => StudentUser::all()->random()->user_id,
        'test_id' => Test::all()->random()->id
    ];
});
