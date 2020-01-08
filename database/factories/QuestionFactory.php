<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Question;
use App\Model\Test;

use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'test_id' => Test::all()->random()->id,
        'question' => $faker->paragraph,
        'question_image' => $faker->imageUrl($width = 640, $height = 480),
        'question_type' => $faker->numberBetween(1,3),
        'question_duration' => $faker->numberBetween(1,300),
        'question_score' => $faker->numberBetween(1,10)
    ];
});
