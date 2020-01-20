<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'image_url' => $this->getFirstMedia('image')->getUrl(),
            'thumb' => $this->getFirstMedia('image')->getUrl('thumb'),
            'is_active' => $this->is_active,
            'lessons' => LessonResource::collection($this->lessons),
            'users' => CourseUserResource::collection($this->whenLoaded('users')),
        ];
    }
}
