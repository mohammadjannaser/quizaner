<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\TestResult;
use App\Model\User;
use App\Model\Test;


use Faker\Generator as Faker;

$factory->define(TestResult::class, function (Faker $faker) {
    return [
        // 
        'user_id' => User::all()->random()->id,
        'test_id' => Test::all()->random()->id,
        'correct_answer' => $faker->numberBetween(0,200),
        'wrong_answer' => $faker->numberBetween(0,200),
        'score' => $faker->numberBetween(0,200),
        'duration_time' => $faker->numberBetween(0,500),
        'rank' => $faker->numberBetween(0,2000)
    ];
});
