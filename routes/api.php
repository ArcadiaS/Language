<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/user', 'Api\UserController@index');

    Route::apiResource('courses', 'Api\CourseController');
});
