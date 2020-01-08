<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class InstructorUser extends Model
{
    //
    public function tests(){
        return $this->hasMany(Test::class);
    }
}
