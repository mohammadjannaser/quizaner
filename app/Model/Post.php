<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id','post_text','post_image'];
    //
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
