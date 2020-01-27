<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\User;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {
    return [

        /***
         * phone
         * facebook_id
         * google_id
         * user_type
         */

        'phone' => $faker->e164PhoneNumber,
        'facebook_id' =>$faker->uuid,
        'google_id' => $faker->uuid
      
    ];
});
