<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\StudentUser;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(StudentUser::class, function (Faker $faker) {
    return [
        /***
         * user_id
         * username
         * user_address
         * dob
         * user_bio
         * user_profile_picture
         */
        // 'user_id' => function(){
        //     return User::all()->random();
        // },
        // get user id as argument
        'username' => $faker->name,
        'user_address' => $faker->address,
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_bio' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'user_profile_picture' => $faker ->imageUrl($width = 640, $height = 480)


    ];
});
