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




Route::apiResource('/feedback','FeedbackController');


Route::group(['prefex' =>'api'],function(){


    // User route seciton
    Route::post('/login','UserController@login');
    Route::post('/getUserDetails','UserController@getUserDetails');
    Route::get('/usersToFollow','UserController@usersToFollow');
    Route::post('/getAllUserFriends','UserController@getAllUserFriends');
    Route::post('/saveUserDetails','UserController@saveUserDetails');


    // Post route Section
    Route::get('/allPost','PostController@allPost');
    Route::post('/getUserPosts','PostController@getUserPosts');


    // Test route Section
    Route::get('/topTest','TestController@topTest');
    Route::post('/suggestionsTest','TestController@suggestionsTest');
    Route::post('/moreQuizzes','TestController@moreQuizzes');

    Route::post('/getUserQuizzes','TestController@getUserQuizzes');
    Route::post('/getUserQuizzesReport','TestController@getUserQuizzesReport');
    Route::get('/allTest','TestController@allTest');
    Route::post('/getStudentEnrolledTest','TestController@getStudentEnrolledTest');
    Route::post('/getTestEnrolledUsers','TestController@getTestEnrolledUsers');
 
    Route::get('/getTestCategory','TestController@getTestCategory');
    Route::post('/getTestDetails','TestController@getTestDetails');
    Route::post('/createTest','TestController@createTest');
    Route::post('/updateTest','TestController@updateTest');
    Route::post('/deleteTest','TestController@deleteTest');
    Route::post('/getAllTestDetails','TestController@getAllTestDetails');




    // Test Result Route Section
    Route::post('/getAllUserResult','TestResultController@getAllUserResult');
    Route::post('/getUserTopTenResult','TestResultController@getUserTopTenResult');
    Route::post('/getTestUsersResult','TestResultController@getTestUsersResult');
    Route::post('/getChallengersResult','TestResultController@getChallengersResult');
    Route::post('/saveUserResult','TestResultController@saveUserResult');



    // Question route list
    Route::post('/getTestQuestions','QuestionController@getTestQuestions');
    Route::post('/createQuestion','QuestionController@createQuestion');
    Route::post('/updateQuestion','QuestionController@updateQuestion');
    Route::post('/deleteQuestion','QuestionController@deleteQuestion');

    // Post Section route list
    Route::post('/createPost','PostController@createPost');
    Route::post('/updatePost','PostController@updatePost');
    Route::post('/deletePost','PostController@deletePost');

    //Follow User
    Route::post('/followUser','FollowerController@followUser');

    // Enroll user
    Route::post('enrollUserForTest','EnrolledUserController@enrollUserForTest');



});





