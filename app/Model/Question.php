<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = ['test_id',
    'question_text','question_image','question_type', 'test_id', 'question_mark',
    ];

    //
    public function answers(){
        return $this->hasMany(Answer::class);
    }
    public function test(){
        return $this->belongsTo(Test::class);
    }
}
