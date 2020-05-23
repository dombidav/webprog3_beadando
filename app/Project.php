<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int user_id
 * @property string description
 * @property string name
 * @property string is_private
 * @property DateTime completed
 * @property DateTime deadline
 * @property int id
 */
class Project extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function users(){
        return $this->belongsToMany('App\User', 'user_project', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    /**
     * @return User
     */
    public function owner(){
        return User::query()->where('id', '=', $this->user_id)->first(); //$this->belongsTo('App\User');
    }
}
