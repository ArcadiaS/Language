<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Lesson extends Model implements HasMedia
{
    use HasMediaTrait;

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(368)->height(232);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
    }

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    protected $guarded = [

    ];

    protected $appends = [
        'is_active',
        'content_counts',
        'user_content_counts',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }

    public function getContentCountsAttribute()
    {
        return $this->quizzes->sum('question_counts');
    }

    public function getUserContentCountsAttribute()
    {
        $count = 0 ;
        $quizzes = Auth::user()->quizzes()->where('quiz_id', $this->id)->wherePivot('finished', 1)->get();
        foreach ($quizzes as $quiz){
            $count += $quiz->questions->count();
        }
        return $count;
    }

    public function getIsActiveAttribute()
    {
        if (Auth::user()->quizzes()->where('lesson_id', $this->id)->wherePivot('finished', 0)->exists()) {
            return false;
        }

        return true;
    }
}
