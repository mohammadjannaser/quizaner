<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\InstructorFollower;
use App\Model\StudentUser;
use App\Model\InstructorUser;
use Faker\Generator as Faker;

$factory->define(InstructorFollower::class, function (Faker $faker) {
    return [
        /****
         * user_id
         * instructor_id
         */
 
        'user_id' => StudentUser::all()->random()->user_id,
        'instructor_id' => InstructorUser::all()->random()->instructor_id
    ];
});
