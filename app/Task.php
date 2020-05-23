<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    public static function tasksAssigned(User $user, int $project_id)
    {
        return DB::table('tasks')->where('user_id', '=', $user->id)->where('project_id', '=', $project_id);
    }

    public function owner(){
        return $this->belongsTo('App\User');
    }

    public function users(){
        return $this->belongsToMany('App\User');
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }
}
