<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Posts extends Model
{
     protected $fillable = [
        'user_id',
    ];
    protected $table = 'posts';

    public function UserId()
    {
    	return $this->hasOne('App\User','id','user_id');
    }

     public function photoPost()
    {
        return $this->hasMany('App\Photo','post_id');
    } 

    public function commentPost()
    {
        return $this->hasMany('App\Comments','post_id');
    } 
   

    public function likePost()
    {
        return $this->hasMany('App\Likes','post_id');
    }

    public function countLike($post_id)
    {
      return  count(DB::table('likes')
                ->where('status', 'like')
                ->where('post_id',$post_id)->get()->toArray());
                
    }


    
}
