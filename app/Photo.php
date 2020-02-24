<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
   protected $fillable = [
        'user_id','post_id','photo',
    ];
    protected $table = 'photos';
	public function photo_count()
     {
     	 return $this->belongsTo('App\Posts', 'post_id', 'id');
    }
     
}
