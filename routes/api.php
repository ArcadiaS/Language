<?php

use Illuminate\Http\Request;
Route::post('register', 'Auth\RegisterController@register');

Route::group(['middleware' => ['auth:api']], function () {

    Route::get('/user', 'Api\UserController@index');

    Route::apiResource('courses', 'Api\CourseController');
    Route::apiResource('courses.lessons', 'Api\LessonController');

    Route::post('courses/{course}/lessons/{lesson}/quizzes/{quiz}/finish', 'Api\QuizController@finishQuiz');
    Route::apiResource('courses.lessons.quizzes', 'Api\QuizController');
    Route::apiResource('courses.lessons.trainings', 'Api\TrainingController');

    Route::apiResource('quizzes.questions', 'Api\QuestionController');
    Route::apiResource('quizzes.questions.answers', 'Api\AnswerController');

    Route::apiResource('users', 'Api\UserController');
    Route::apiResource('users.profiles', 'Api\ProfileController');
});
