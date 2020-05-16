<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function tasks(){
        return $this->belongsToMany('App\Task');
    }

    public function projects(){
        return $this->belongsToMany('App\Project', 'user_project');
    }

    public function inbox(){
        return $this->hasMany('App\Message', 'recipient_id');
    }

    public function sent(){
        return $this->hasMany('App\Message', 'sender_id');
    }

    public function files(){
        return $this->hasMany('App\File');
    }
}
