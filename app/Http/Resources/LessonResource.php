<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'is_active' => $this->is_active,
            'content_count' => $this->content_count,
            'user_content_counts' => $this->user_content_counts,
            'course' => CourseResource::make($this->whenLoaded('course')),
            'quizzes' => QuizResource::collection($this->whenLoaded('quizzes'))
        ];

    }
}
