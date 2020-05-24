<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method static Builder where(string $string, string $string1, $get)
 * @method static User|Collection<User> find()
 * @method static find($user_id)
 * @property User inbox
 * @property Collection<Mail> sent
 * @property int|null auth
 * @property Collection<Project> projects
 * @property string username
 */
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

    public static function name(string $str){
        return User::where('username', '=', $str)->first();
    }

    public function tasks(){
        return $this->belongsToMany('App\Task', 'user_task');
    }

    public function projects(){
        return $this->belongsToMany('App\Project', 'user_project');
    }

    public function owned_projects(){
        return $this->hasMany('App\Project');
    }

    public function inbox(){
        return $this->hasMany('App\Mail', 'recipient_id');
    }

    public function sent(){
        return $this->hasMany('App\Mail', 'sender_id');
    }

    public function files(){
        return $this->hasMany('App\File');
    }

    /**
     * @return int
     */
    public function inbox_count(){
        return $this->inbox->where('is_new', '==', 1)->count();
    }
}
