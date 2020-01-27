<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserDetail;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(UserDetail::class, function (Faker $faker) {
    return [
        /***
         * user_id
         * username
         * phone
         * country
         * dob
         * user_bio
         * user_profile_picture
         * verified
         * user_type
         */
        
        'username' => $faker->name,
        'country' => $faker->address,
        'phone' => $faker->e164PhoneNumber,
        'dob' => $faker->date($format = 'Y-m-d', $max = 'now'),
        'user_bio' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'user_profile_picture' => $faker ->imageUrl($width = 640, $height = 480),
        'verified' => $faker->numberBetween(0,1),
        'user_type' => $faker->numberBetween(0,1)


    ];
});
