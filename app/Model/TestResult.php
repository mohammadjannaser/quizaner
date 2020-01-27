<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class TestResult extends Model
{
    //
    public function test(){
        return $this->belongsTo(Test::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
