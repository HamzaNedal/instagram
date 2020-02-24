<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Message extends Model
{

    protected $fillable = [
        'body','sender_id','receiver_id','image'
    ];
    protected $table='messages';

    public function getUserData()
    {
        return $this->belongsTo('App\User','receiver_id');
    }

    public function getUserDataSender()
    {
        return $this->belongsTo('App\User','sender_id');
    }
}
