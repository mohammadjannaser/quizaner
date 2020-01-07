<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\InstructorUser;
use App\Model\User;
use App\Model\StudentUser;

use Faker\Generator as Faker;

$factory->define(InstructorUser::class, function (Faker $faker) {
    return [
        /***
         * instructor_id
         * instructor_name
         * instructor_bio
         * instructor_phone
         * instructor_address
         * user_profile_picture
         */

        'instructor_id' => function(){

            return User::all('id')->random();
            // return  User::pluck('id')->whereNotIn('id',$studentIdList)->get()->random();

        },
        'instructor_name' => $faker->name,
        'instructor_address' => $faker->address,
        'instructor_bio' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'instructor_phone' => $faker->e164PhoneNumber,
        'user_profile_picture' => $faker ->imageUrl($width = 640, $height = 480)


    ];
});
