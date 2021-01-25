<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $guarded = [];


    public function owner()
    {
        //관례 안따르기에 user_id 입력해줘야함!
        return $this->belongsTo(User::class , 'user_id');
    }
}
