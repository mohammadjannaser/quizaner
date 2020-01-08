<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    //
    public function user(){
       return $this->belongsTo(StudentUser::class);
    }
}
