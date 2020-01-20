<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
        //return [
        //    'finished' => $this->pivot->finished,
        //    'training_finished' => $this->pivot->training_finished,
        //    'points' => $this->pivot->points,
        //];
    }
}
