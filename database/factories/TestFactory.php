<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Test;
use App\Model\InstructorUser;
use App\Model\TestCategory;

use Faker\Generator as Faker;

$factory->define(Test::class, function (Faker $faker) {
    return [
        /***********
         * instructor_id
         * test_name
         * test_duration
         * number_of_question
         * test_score
         * test_hoding_date
         * test_description
         * test_cost
         * test_privacy
         * test_category
         */
        'instructor_id' => InstructorUser::all()->random()->instructor_id,
        'test_name' => $faker->sentence($nbWords = 5, $variableNbWords = true) ,
        'test_duration' => $faker->numberBetween(1,200),
        'number_of_question' => $faker->numberBetween(1,100),
        'test_score' =>$faker->numberBetween(1,500),
        'test_holding_date' => $faker->dateTime($max = 'now', $timezone = null),
        'test_description' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        'test_cost' => $faker->numberBetween(1,100),
        'test_privacy' => $faker->numberBetween(1,2),
        'test_category' => TestCategory::all()->random()->id,
        'test_image' =>  $faker ->imageUrl($width = 640, $height = 480)

    ];
});
