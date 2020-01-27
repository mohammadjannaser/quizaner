<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});





Route::apiResource('/tests','TestController');

Route::apiResource('/feedback','FeedbackController');


Route::group(['prefex' =>'api'],function(){

    Route::post('/login','UserController@login');
    Route::post('/getUserDetails','UserController@getUserDetails');
    
    Route::post('/getAllUserFriends','UserController@getAllUserFriends');


    Route::get('/allTest','TestController@allTest');
    Route::get('/allPost','PostController@allPost');


    Route::post('/getUserPosts','PostController@getUserPosts');

    Route::get('/topTest','TestController@topTest');
    Route::post('/getUserQuizzes','TestController@getUserQuizzes');
    
    Route::get('/usersToFollow','UserController@usersToFollow');

    Route::post('/getUserTopTenResult','TestResultController@getUserTopTenResult');

    Route::post('/getChallengersResult','TestResultController@getChallengersResult');

    Route::post('/getStudentEnrolledTest','TestController@getStudentEnrolledTest');

    Route::post('/getAllUserResult','TestResultController@getAllUserResult');

});


Route::group(['prefex'=>'tests'],function(){
    Route::apiResource('/tests/{tests}/questions','QuestionController');
});



