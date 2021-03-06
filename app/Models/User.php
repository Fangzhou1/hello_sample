<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\ResetPassword;

class User extends Authenticatable
{
    use Notifiable,HasRoles;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'is_admin','name', 'email', 'password','remember_token','avatar','introduction','activated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
       {
           parent::boot();

           static::creating(function ($user) {
               $user->activation_token = str_random(30);
           });
       }

       public function getActivatedAttribute($value)
          {
              return $value==1?"已激活":"未激活";
          }

      public function sendPasswordResetNotification($token)
        {
            $this->notify(new ResetPassword($token));
        }


}
