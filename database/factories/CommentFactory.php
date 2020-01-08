<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Comment;
use App\Model\Post;
use App\Model\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        /***
         * post_id
         * user_id
         * comment_text
         */
        'user_id' => function(){
            return User::all()->random();
        },
        'comment_text' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)

    ];
});
