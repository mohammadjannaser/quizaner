<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
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
            'instructor_id' => $this->instructor_id,
            'test_name' => $this->test_name,
            'test_date_time' => $this->test_hoding_date,//in the next migration fix hoding name
            'test_cost' => $this->test_cost,
            'description' => $this->test_description,
            'test_image' => $this->test_image,
            'href' => [
                'questions' => route('questions.index',$this->id)
            ]
        ];
    }
}
