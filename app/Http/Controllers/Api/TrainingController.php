<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\QuizResource;
use App\Http\Resources\TrainingResource;
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
        $trainings = $course->trainings()->where('lesson_id', $lesson->id)->get();

        return response()->json(TrainingResource::collection($trainings));
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Training $training
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, Training $training, Course $course, Lesson $lesson)
    {
        $user = $request->user();

        if (!$user->trainings()->where('training_id', $training->id)->exists()){
            $user->trainings()->attach($training);
            return response()->json('Başarılı', 200);
        }

        return response()->json('Başarısız', 404);
    }

    /**
     * Display the specified resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @param \App\Models\Training $training
     * @return void
     */
    public function show(Request $request, Course $course, Lesson $lesson, Training $training)
    {
        return response()->json(TrainingResource::make($training));
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
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Training $training
     * @param \App\Models\Course $course
     * @param \App\Models\Lesson $lesson
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Course $course, Lesson $lesson, Training $training)
    {
        $user = $request->user();

        if (!$user->trainings()->where('training_id', $training->id)->exists()){
            $user->trainings()->attach($training);
            $user->trainings()->updateExistingPivot($training->id, ['finished' => 1, 'latest_location' => $request->latest_location]);

            return response()->json('Başarılı', 200);
        }
        $user->trainings()->updateExistingPivot($training->id, ['finished' => 1, 'latest_location' => $request->latest_location]);

        return response()->json('Başarılı', 200);
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
