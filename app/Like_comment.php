<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like_comment extends Model
{
   protected $table = 'like_comments';

   protected $fillable = [
   	'status',
   	'user_id',
   	'post_id',
   	'comment_id',
   ];
   public function User_id()
   {
   		return $this->belongsTo('App\User','user_id');
   }
}	
