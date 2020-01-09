<?php

namespace App\Http\Resources\Test;

use Illuminate\Http\Resources\Json\Resource;

class TestCollection extends Resource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'test_name' => $this->test_name,
            'test_date_time' => $this->test_hoding_date,//in the next migration fix hoding name
            'test_image' => $this->test_image,
            'href' =>[
                'link' => route('tests.show',$this->id)
            ]
        
        ];
    }
}
