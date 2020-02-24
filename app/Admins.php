<?php

namespace App;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CRP;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;
use App\Notifications\RestPasswordAdmins;
class Admins extends Model  implements AuthenticatableContract,CRP{

    use Authenticatable;use CanResetPassword;use Notifiable;

    

     protected $fillable = [
        'name','password','photo','email'
    ];

    public function sendPasswordResetNotification($token)
    {

        $this->notify(new RestPasswordAdmins($token));
    }


}
