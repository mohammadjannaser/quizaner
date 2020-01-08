<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\UserSelectedCategory;
use App\Model\TestCategory;
use App\Model\StudentUser;

use Faker\Generator as Faker;

$factory->define(UserSelectedCategory::class, function (Faker $faker) {
    return [
        
        'user_id' => StudentUser::all()->random()->user_id,
        'category_id' => TestCategory::all()->random()->id
    ];
});
