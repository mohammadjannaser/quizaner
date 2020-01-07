<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Post;
use App\Model\User;


use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        /***
         * user_id
         * post_text
         * post_image
         */
        'user_id' => function(){
            return User::all()->random();
        },
        'post_text' => $faker->paragraph($nbSentences = 5, $variableNbSentences = true),
        'post_image' => $faker ->imageUrl($width = 640, $height = 480)

    ];
});
