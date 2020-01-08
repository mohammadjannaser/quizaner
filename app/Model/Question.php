<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //
    public function answers(){
        return $this->hasMany(Answers::class);
    }
    public function test(){
        return $this->belongsTo(Test::class);
    }
}
