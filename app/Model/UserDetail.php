<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    //
    public function credit(){
        return $this->hasOne(Credit::class);
    }
    public function selectedCategory(){
        return $this->hasMany(UserSelectedCategory::class);
    }
    public function inrolledUser()
    {
        return $this->hasMany(InrolledUser::class);
    }
}
