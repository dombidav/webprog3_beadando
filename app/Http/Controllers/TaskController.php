<?php

namespace App\Http\Controllers;

use App\Helpers\LINQ;
use App\Project;
use App\Task;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Whoops\Exception\Formatter;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @param $target
     * @param Collection $tasks
     * @return \Illuminate\Support\Collection
     */
    private static function target_filter($target, Collection $tasks)
    {
        if ($target == '$')
            $target = Auth::user()->username;
        $temp = [];
        /** @var Task $task */
        foreach ($tasks as $task) {
            if (Task::owner_of($task) != null && Task::owner_of($task)->username == $target) {
                array_push($temp, $task);
            }
        }
        return collect($temp);
    }

    /**
     * @param $filter
     * @param Collection $tasks
     * @return Collection
     */
    private static function status_filter($filter, $tasks)
    {
        switch ($filter) {
            case 'active':
                $tasks = $tasks->where('status', '<>', '0')->where('completed', '==', null);
                break;
            case 'done':
                $tasks = $tasks->where('completed', '<>', null);
                break;
            case 'backlog':
                $tasks = $tasks->where('status', '==', '0')->where('completed', '==', null);
                break;
        }
        return $tasks;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Response|View
     */
    public function index()
    {
        /** @var Collection $tasks */
        if (\request('p') != null) {
            $tasks = Task::where('project_id', '=', \request('p'))->get();
            if (\request('filter') != null) {
                foreach (\request('filter') as $filter) {
                    switch (explode(' ', $filter)[0]) {
                        case 'status':
                            $tasks = self::status_filter(explode(' ', $filter)[1], $tasks);
                            break;
                        case 'target':
                            $tasks = self::target_filter(explode(' ', $filter)[1], $tasks);
                            break;
                        default:
                            break;
                    }
                }
            }
            return view('task.index', ['tasks' => $tasks, 'project' => Project::find(request('p'))]);
        } else if (Auth::user()->auth == 9) {
            return view('task.index_admin', ['user' => Auth::user(), 'tasks' => Task::query()->paginate(20)]);
        } else {
            abort(403, 'Task view only available for administrators');
        }
    }

    public function apiShow($id)
    {
        return json_encode(Task::find($id));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Task $task
     * @return Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Task $task
     * @return Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Task $task
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function update(Request $request, Task $task = null)
    {
        if ($request->get('task_id') == -1) {
            $task = Task::createFrom($request->all(), ['user_id' => Auth::id(), 'project_id' => $request->get('project_id')], ['new_responsibles'])->save();
        } else {
            $request->validate([
                'new_title' => 'required|max:250'
            ]);
            if ($task == null)
                $task = Task::find($request->get('task_id'));
            if (Auth::user()->auth != 9 && $task->owner()->id != Auth::id())
                abort(403, 'Only the owner can edit this item');
            $task->title = $request->get('new_title');
            if ($request->get('new_content') !== null)
                $task->content = $request->get('new_content');
            if ($request->get('new_deadline') !== null)
                $task->deadline = $request->get('new_deadline');
            if ($request->get('new_status') !== null)
                $task->status = $request->get('new_status');
            $task->save();
        }
        $task = Task::last();
        if (Str::contains($request->get('new_responsibles'), ',')) {
            foreach (explode(',', $request->get('new_responsibles')) as $person) {
                $user = User::name(trim($person, ', '));
                DB::table('user_task')->where('task_id', '=', $task->id)->delete();
                DB::table('user_task')->insert([
                    'user_id' => $user->id,
                    'task_id' => $task->id
                ]);
            }
        }

        return redirect()->route('tasks.index', ['p' => $task->project->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Task $task
     * @return \Illuminate\Http\RedirectResponse|Response
     * @throws \Exception
     */
    public function destroy(Task $task)
    {
        if ($task->owner()->id == Auth::id() || Auth::user()->auth == 9) {
            $temp = $task->project->id;
            $task->delete();
            return redirect()->route('tasks.index', ['p' => $temp]);
        } else
            abort(403, 'Only the owner can delete this item');
    }
}
