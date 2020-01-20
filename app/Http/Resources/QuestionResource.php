<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'name_tr' => $this->name_tr,
            'description' => $this->description,
            'answers' => AnswerResource::collection($this->answers),
            'user_answer' => AnswerResource::make($this->whenLoaded('user_answer')->first())
        ];
    }
}
