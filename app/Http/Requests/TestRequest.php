<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
     
            //
            'instructor_id' => 'required',
            'test_name' => 'required',
            'test_duration' => 'required',
            'number_of_question' => 'required',
            'test_score' => 'required',
            'test_holding_date' => 'required',
            'test_description' => 'required',
            'test_cost' => 'required',
            'test_privacy' => 'required',
            'test_category' => 'required',
            'test_image' => 'required',
            
        ];
    }
}
