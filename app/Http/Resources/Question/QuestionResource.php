<?php

namespace App\Http\Resources\Question;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Answer\AnswerResource;

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
            'question_text' => $this->question,
            'question_image' => $this->question_image,
            'question_type' => $this->question_type,
            'question_duration' => $this->question_duration,
            'question_score' => $this->question_score,
            'answers' => AnswerResource::collection($this->answers) 
        ];
    }
}
