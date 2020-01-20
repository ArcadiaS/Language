<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Training;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\Response
     */
    public function index(Course $course, Lesson $lesson)
    {
        $quizzes = $course->trainings()->where('lesson_id', $lesson->id)->get();

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
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param int $id
     * @param $
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return void
     */
    public function update(Request $request, $id, Course $course, Lesson $lesson)
    {
        $user = $request->user();
        $training = Training::findOrFail($id);

        if (!$user->trainings()->where('training_id', $training->id)->exists()){
            $user->trainings()->attach($training);
            return response()->json('Başarılı', 200);
        }

        return response()->json('Başarısız', 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
