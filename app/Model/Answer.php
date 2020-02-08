<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    protected $fillable = ['question_id','answer1','answer1_image','answer2', 'answer2_image', 'answer3','answer3_image'
            ,'answer4','answer4_image','correct_answer'
    ];

    //
    public function question(){
        return $this->belongsTo(Question::class);
    }
}
