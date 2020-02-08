<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{

    protected $fillable = ['user_id','username','phone','dob','country','user_bio','user_profile_picture'
    ,'verified','user_type'];
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
