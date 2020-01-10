<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Answer;
use App\Model\Question;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'answer1' => $faker->sentence,
        'answer1_image' => $faker->imageUrl($width = 640, $height = 480),
        'answer2' => $faker->paragraph,
        'answer2_image' => $faker->imageUrl($width = 640, $height = 480),
        'answer3' => $faker->paragraph,
        'answer3_image' => $faker->imageUrl($width = 640, $height = 480),
        'answer4' => $faker->sentence,
        'answer4_image' => $faker->imageUrl($width = 640, $height = 480),
        'correct_answer' => $faker->numberBetween(1,4)
    ];
});
