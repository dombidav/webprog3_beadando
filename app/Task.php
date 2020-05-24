<?php

namespace App;

use App\Helpers\LINQ;
use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @method static Task find(int $int)
 * @property Project project
 * @property int id
 * @property int user_id
 * @property array<User> users
 * @property string title
 * @property string content
 * @property DateTime deadline
 * @property int status
 */
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

    public static function safeID(Task $task, bool $prefix = true) : string {
        $project_safe = Project::safeID($task->project, false);
        $i = Task::innerID($task);
        return ($prefix ? 't/' : '') . $project_safe . '/' . $i;
    }

    /**
     * @param Task $task
     * @return User|null
     */
    public static function owner_of(Task $task){
        return \App\User::find($task->user_id);
    }

    public static function innerID(Task $task)
    {
        $all_task = DB::table('tasks')->where('project_id', '=', $task->project->id)->get();
        $i = 0;
        while ($all_task->skip($i)->first()->id != $task->id){
            $i++;
        }
        return $i;
    }

    public static function createFrom(array $all, array $and = [], array $except = []) : Task
    {
        $array = [];
        foreach ($all as $key => $value) {
            if(Str::startsWith($key, 'new_') && LINQ::from($except)->notContains($key)){
                $array[Str::substr($key, 4)] = $value;
            }
        }
        foreach ($and as $key=>$value){
            $array[$key] = $value;
        }
        return new Task($array);
    }

    public static function last()
    {
        return Task::query()->orderBy('id', 'DESC')->limit(1)->get()->first();
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_task');
    }

    public static function userString(Task $task){
        $temp = '';
        foreach ($task->users as $u){
            $temp .= $u->username . ', ';
        }
        return trim($temp, ', ');
    }

    public static function from(string $str){
        preg_match('/([a-z])\/([a-z0-9._-]+)\/([0-9]+)(?:\/([0-9]+))*/', $str, $matches, PREG_UNMATCHED_AS_NULL);
        if(sizeof($matches) == null)
            return null;
        /** @var Project $project */
        $project = Project::from($str);
        return $project->tasks->skip($matches[3])->first();
    }

    public function project(){
        return $this->belongsTo('App\Project');
    }

    public function owner(){
        return User::query()->where('id', '=', $this->user_id)->first(); //$this->belongsTo('App\User');
    }
}
