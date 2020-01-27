<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Feedback;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'user_id' => User::all()->random()->id,
        'feedback' => $faker->paragraph
    ];
});
