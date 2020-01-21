<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use function Composer\Autoload\includeFile;

class Answer extends Model implements HasMedia
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
        'correct' => 'boolean'
    ];

    protected $guarded = [

    ];

    protected $appends = [
      'selected'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function user_answers()
    {
        return $this->belongsToMany(User::class)->withPivot('question_id')->wherePivot('question_id', $this->question_id);
    }

    public function getSelectedAttribute()
    {
        return $this->user_answers()->count() > 0;
    }
}
