<?php

namespace App\Models;

use App\Enums\QuestionType;
use BenSampo\Enum\Traits\CastsEnums;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Question extends Model implements HasMedia
{
    use HasMediaTrait, CastsEnums;

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
    protected $casts = [
        'type' => 'int',
    ];

    protected $enumCasts = [
        // 'attribute_name' => Enum::class
        'type' => QuestionType::class,
    ];

    protected $guarded = [

    ];

    protected $appends = [];

    protected $with = [
        'user_answer',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function user_answer()
    {
        return $this->belongsToMany(Answer::class, 'answer_user')->where('user_id', Auth::user()->id)->latest();
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
