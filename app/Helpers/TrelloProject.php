<?php


namespace App\Helpers;


use App\Project;
use App\Task;
use App\User;
use DateTime;
use Illuminate\Support\Facades\Auth;

class TrelloProject
{
    /** @var string $name */
    public $name;

    /** @var string $desc */
    public $desc;
    /**
     * @var array
     */
    public $members;
    /**
     * @var array
     */
    public $status;
    /**
     * @var array
     */
    public $tasks;
    /**
     * @var array
     */
    public $member_assoc;

    public function __construct($object)
    {
        $this->name = $object->name;
        $this->desc = $object->desc;
        $this->members = [];
        $this->status = [];
        $this->tasks = [];
        $this->member_assoc = [];
        foreach ($object->members as $member) {
            $this->members[$member->id] = $member->username;
        }
        foreach ($object->lists as $key => $list) {
            $this->status[$list->id] = $key;
        }
        foreach ($object->cards as $card) {
            $user = Auth::user();
            $task = new Task([
                'title' => $card->name,
                'user_id' => $user->id,
                'content' => $card->desc,
                'deadline' => (new DateTime($card->due))->format('Y-m-d H:i:s'),
                'status' => $this->status[$card->idList]
            ]);
            array_push($this->member_assoc, ['user' => $user, 'task' => $task]);
            foreach ($card->idMembers as $idMember) {
                $name = $this->members[$idMember];
                $idMember = User::name($name);
                array_push($this->member_assoc, ['user' => Auth::user(), 'task' => $task]);
                if ($idMember != null)
                    array_push($this->member_assoc, ['user' => $idMember, 'task' => $task]);
                if(config('app.debug') == true && $idMember == null){
                    $idMember = factory('App\User')->create(['username' => $name]);
                    array_push($this->member_assoc, ['user' => $idMember, 'task' => $task]);
                }
            }
            array_push($this->tasks, $task);
        }
    }

    public function project(): Project
    {
        return new Project([
            'name' => $this->name,
            'user_id' => Auth::id(),
            'description' => $this->desc
        ]);
    }
}
