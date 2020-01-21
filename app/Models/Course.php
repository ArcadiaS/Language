<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Course extends Model implements HasMedia
{
    use HasMediaTrait;

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(368)
            ->height(232);
    }

    public function registerMediaCollections()
    {
        $this->addMediaCollection('image')->singleFile();
    }

    protected $with = [
        'media'
    ];
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
    protected $casts = [
    ];

    protected $guarded = [

    ];

    protected $appends = [
      'is_active',
      'user_points_earned',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('finished', 'training_finished', 'points');
    }

    public function getIsActiveAttribute()
    {
        if ($this->stage <= Auth::user()->active_stage){
            return true;
        }
        return false;
    }

    public function getUserPointsEarnedAttribute()
    {
        $course = Auth::user()->courses()->wherePivot('course_id', $this->id)->first();
        if ($course) return $course->pivot->points;
        return 0;
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function quizzes()
    {
        return $this->hasManyThrough(Quiz::class, Lesson::class);
    }

    public function trainings()
    {
        return $this->hasManyThrough(Training::class, Lesson::class);
    }
}
