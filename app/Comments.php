<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    protected $fillable = [
        'user_id','post_id','comments',
    ];
    protected $table = 'comments';
      public function UserId()
    {
    	return $this->hasOne('App\User','id','user_id');
    }
	 public function CommentLike()
    {
        return $this->hasMany('App\Like_comment','comment_id');
    } 

    public function Comment_reply()
    {
    	return $this->hasMany('App\ReplyComment','comment_id');
    }
}
