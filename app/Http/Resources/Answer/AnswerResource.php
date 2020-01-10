<?php

namespace App\Http\Resources\Answer;

use Illuminate\Http\Resources\Json\JsonResource;

class AnswerResource extends JsonResource
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
            'answer1' => $this->answer1,
            'answer1_image' => $this->answer1_image,
            'answer2' => $this->answer2,
            'answer2_image' => $this->answer2_image,
            'answer3' => $this->answer3,
            'answer3_image' => $this->answer3_image,
            'answer4' => $this->answer4,
            'answer4_image' => $this->answer4_image,
            'correct_answer' => $this->correct_answer
        ];
    }
}
