<?php

use Illuminate\Http\Request;


Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/user', 'Api\UserController@index');

    Route::apiResource('courses', 'Api\CourseController');
    Route::apiResource('courses.lessons', 'Api\LessonController');
    Route::apiResource('courses.lessons.quizzes', 'Api\QuizController');
    Route::apiResource('courses.lessons.trainings', 'Api\TrainingController');

    Route::apiResource('quizzes.questions', 'Api\QuestionController');
    Route::apiResource('quizzes.questions.answers', 'Api\QuestionController');

    Route::apiResource('users', 'Api\UserController');
    Route::apiResource('users.profiles', 'Api\ProfileController');
});
