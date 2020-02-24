<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Likes extends Model
{
     protected $fillable = [
        'user_id','post_id','status',
    ];
    protected $table = 'likes';
    
    public function UserId()
    {
    	return $this->hasOne('App\User','id','user_id');
    }
}
