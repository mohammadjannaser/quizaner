<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    public function questions(){
        return $this->hasMany(Question::class);
    }
    public function testResult(){
        return $this->hasMany(TestResult::class);
    }
}
