<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stack extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
