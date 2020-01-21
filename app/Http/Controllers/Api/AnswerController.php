<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Question $question
     * @param \App\Models\Answer $answer
     * @return void
     */
    public function store(Request $request, Quiz $quiz, Question $question, Answer $answer)
    {
        $user = $request->user();

        if ($user->answers()->where('question_id', $question->id)->where('answer_id', $answer->id)->exists()) {
            return response()->json(true);
        }

        $user->answers()->attach($answer, ['question_id' => $question->id]);

        return response()->json('Cevaplandı');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @param \App\Models\Quiz $quiz
     * @param \App\Models\Question $question
     * @param \App\Models\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Quiz $quiz, Question $question, Answer $answer)
    {
        $user = $request->user();

        $quiz = $user->quizzes()->where('quiz_id', $quiz->id)->firstOrFail();
        $points = $quiz->pivot->points;

        if ($request->has('points') and !$user->answers()->wherePivot('question_id', $question->id)->exists()) {
            $user->courses()->updateExistingPivot($quiz->course_id, ['points' => ($points)]);

            return response()->json('Başarılı');
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
}
