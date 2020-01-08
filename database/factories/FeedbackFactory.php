<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Feedback;
use App\Model\StudentUser;
use Faker\Generator as Faker;

$factory->define(Feedback::class, function (Faker $faker) {
    return [
        'user_id' => StudentUser::all()->random()->user_id,
        'feedback' => $faker->paragraph
    ];
});
