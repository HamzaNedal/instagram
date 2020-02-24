<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable = [
        'followers','following',
    ];
     protected $table = 'follows';
    public function follow()
    {
    	return $this->hasOne('App\User','id','followers');
    } 

    public function follow_ing()
    {
    	return $this->hasOne('App\User','id','following');
    }
}