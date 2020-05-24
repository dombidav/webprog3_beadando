<?php

namespace App;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @property int user_id
 * @property string description
 * @property string name
 * @property string is_private
 * @property DateTime completed
 * @property DateTime deadline
 * @property int id
 * @property Collection<Task> tasks
 * @property Collection<User> users
 * @method static Project find($project_id)
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

    public static function safeID(Project $project, bool $prefix = true) : string
    {
        $i = Project::innerID($project);
        return ($prefix ? 'p/' : '') . $project->owner()->username . '/' . $i;
    }

    public static function from(string $str){
        preg_match('/([a-z])\/([a-z0-9._-]+)\/([0-9]+)(?:\/([0-9]+))*/', $str, $matches, PREG_UNMATCHED_AS_NULL);
        if(sizeof($matches) == null)
            return null;
        $user_id = User::name($matches[2])->id;
        return Project::where('user_id', '=', $user_id)->get()->skip($matches[3])->first();
    }

    public static function innerID(Project $project)
    {
        $all_task = DB::table('projects')->where('user_id', '=', $project->owner()->id)->get();
        $i = 0;
        while ($all_task->skip($i)->first()->id != $project->id){
            $i++;
        }
        return $i;
    }


    /**
     * @return Project
     */
    public static function last()
    {
        return Project::query()->orderBy('id', 'DESC')->limit(1)->get()->first();
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_project', 'project_id', 'user_id');
    }

    public function tasks(){
        return $this->hasMany('App\Task');
    }

    public function owner(){
        return User::query()->where('id', '=', $this->user_id)->first(); //$this->belongsTo('App\User');
    }
}
