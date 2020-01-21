<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return void
     */
    public function index(Course $course, Lesson $lesson)
    {
        $quizzes = $course->quizzes()->where('lesson_id', $lesson->id)->get();

        return response()->json(QuizResource::collection($quizzes));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return void
     */
    public function store(Request $request, Course $course, Lesson $lesson)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @param \App\Models\Quiz $quiz
     * @return void
     */
    public function show(Request $request, Course $course, Lesson $lesson, Quiz $quiz)
    {
        return response()->json(QuizResource::make($quiz));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course, Lesson $lesson, Quiz $quiz)
    {
        $user = $request->user();

        if (! $user->quizzes()->where('quiz_id', $quiz->id)->exists()) {
            $user->quizzes()->attach($quiz, ['points' => $request->points]);
        }

        return response()->json('Başarılı');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @param \App\Models\Quiz $quiz
     * @return \Illuminate\Http\JsonResponse
     */
    public function finishQuiz(Request $request, Course $course, Lesson $lesson, Quiz $quiz)
    {
        $user = $request->user();
        $user->quizzes()->updateExistingPivot($quiz->id, ['finished' => 1]);

        if ($user->quizzes()->wherePivot('finished', 1)->count() == $course->quizzes()->count()){
            $user->courses()->updateExistingPivot($course->id, ['finished' => 1]);
        }

        return response()->json(true);
    }
}
