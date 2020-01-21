<?php

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Quiz extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    protected $appends = [
        'is_active',
        'question_counts',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $guarded = [

    ];

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function getQuestionCountsAttribute()
    {
        return $this->questions()->count();
    }

    public function getIsActiveAttribute()
    {
        if (Auth::user()->quizzes()->where('quiz_id', $this->id)->wherePivot('finished', 1)->exists()) {
            return false;
        }

        return true;
    }
}
