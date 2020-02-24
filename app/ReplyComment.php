<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReplyComment extends Model
{
    protected $table = 'reply_comments';

   protected $fillable = [
   	'reply_comment',
   	'user_id',
   	'post_id',
   	'comment_id',
   ];

   public function User_id()
   {
   		return $this->belongsTo('App\User','user_id');
   }
}
