<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{

    protected $fillable = [
        'instructor_id','test_name','number_of_question','test_score',
        'test_holding_date','test_description','test_cost','test_privacy',
        'test_duration','test_category','test_image'
        
    ];
    //
    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function testResult(){
        return $this->hasMany(TestResult::class);
    }
}
