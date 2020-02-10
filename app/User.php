<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'surname',
        'email',
        'password',
        'birth_date',
        'course_stage',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be append to arrays.
     *
     * @var array
     */
    protected $appends = [
       'full_name'
    ];

    public function getFullNameAttribute()
    {
        return $this->name.' '.$this->surname;
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot('finished', 'training_finished', 'points');
    }

    public function answers()
    {
        return $this->belongsToMany(Answer::class)->withPivot('question_id');
    }

    public function trainings()
    {
        return $this->belongsToMany(Training::class)->withPivot('finished', 'latest_location');
    }

    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class)->withPivot('finished', 'latest_location', 'points');
    }

}
