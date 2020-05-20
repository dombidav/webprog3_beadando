<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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

    public function stacks(){
        return $this->hasMany('App\Stack');
    }

    public function owner(){
        return $this->belongsTo('App\User');
    }
}
