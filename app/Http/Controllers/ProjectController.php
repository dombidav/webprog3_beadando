<?php

namespace App\Http\Controllers;

use App\Helpers\JsonUtil;
use App\Helpers\LINQ;
use App\Helpers\TrelloProject;
use App\Project;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
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
     * Display a listing of the resource.
     *
     * @return Factory|Response|View
     */
    public function index()
    {
        return view('project.index', ['owned'=> Auth::user()->owned_projects,'projects' => Auth::user()->projects()->paginate(5)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        return view('project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function store(Request $request)
    {
        switch ($request->get('create_method')) {
            case 'manual':
                $this->manual_create($request);
                break;
            case 'trello':
                $this->trello_create($request);
                break;
        }
        return redirect()->route('projects.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Project $project
     * @return Factory|Response|View
     */
    public function show(Project $project)
    {
        return view('project.show', ['project' => $project]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Project $project
     * @return Factory|Response|View
     */
    public function edit(Project $project)
    {
        return view('project.edit', ['project' => $project]);
    }

    public function memberRemove(Request $request)
    {
        $project = Project::find($request->get('project'));
        $user = User::find($request->get('user'));
        if ($project->user_id == Auth::id() || Auth::user()->auth == 9) {
            if ($user->id == Auth::id()) {
                abort(400, 'You are the owner of this project');
            } else {
                DB::table('user_project')->where('user_id', '=', $user->id)->where('project_id', '=', $project->id)->delete();
                return redirect()->route('projects.show', $project->id);
            }
        } else {
            abort(403, 'Only the owner can remove this person from the project');
        }
    }

    public function memberAdd(Request $request)
    {
        $project = Project::find($request->get('project'));
        if ($project->user_id == Auth::id() || Auth::user()->auth == 9) {
            $request->validate(['new_member' => 'required']);
            if (Str::contains($request->get('new_member'), ',')) {
                foreach (explode(',', $request->get('new_member')) as $user) {
                    $user = User::name($user);
                    if (DB::table('user_project')->where('user_id', '=', $user->id)->where('project_id', '=', $project->id)) {
                        DB::table('user_project')->insert([
                            'user_id' => $user->id,
                            'project_id' => $project->id
                        ]);
                    }
                }
            } else {
                $user = User::name($request->get('new_member'));
                if (DB::table('user_project')->where('user_id', '=', $user->id)->where('project_id', '=', $project->id)) {
                    DB::table('user_project')->insert([
                        'user_id' => $user->id,
                        'project_id' => $project->id
                    ]);
                }
            }
            return redirect()->route('projects.show', $project->id);
        } else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function update(Request $request, Project $project)
    {
        if ($request->get('new_name'))
            $project->name = $request->get('new_name');
        if ($request->get('new_description') !== null)
            $project->description = $request->get('new_description');
        if ($request->get('new_user_id') !== null)
            $project->user_id = $request->get('new_user_id');
        if ($request->get('new_is_private') !== null)
            $project->is_private = $request->get('new_is_private');
        if ($request->get('new_completed') !== null)
            $project->completed = $request->get('new_completed');
        if ($request->get('new_deadline') !== null)
            $project->deadline = $request->get('new_deadline');
        $project->save();
        return redirect()->route('projects.show', $project->id);
    }

    public function export($project_id)
    {
        $project = Project::find($project_id);
        LINQ::from($project->tasks)->csv("{NOW}-$project->name")->download();
    }

    public function destroy(Request $request)
    {
        $project = Project::find($request->get('project_id'));
        if($project->user_id == Auth::id() || Auth::user()->auth == 9){
            $project->delete();
            return redirect()->route('projects.index');
        }else{
            abort(403);
        }
    }

    /**
     * @param Request $request
     */
    private function manual_create(Request $request): void
    {
        $project = new Project([
            'name' => $request->get('new_name'),
            'deadline' => $request->get('new_deadline'),
            'user_id' => Auth::id(),
            'description' => $request->get('new_content')
        ]);
        $project->save();
        $project = Project::last();
        DB::table('user_project')->insert([
            'user_id' => Auth::id(),
            'project_id' => $project->id
        ]);
        if (Str::contains($request->get('new_responsibles'), ',')) {
            foreach (explode(',', $request->get('new_responsibles')) as $person) {
                DB::table('user_project')->insert([
                    'user_id' => $user = User::name($person)->id,
                    'project_id' => $project->id
                ]);
            }
        }
    }

    private function trello_create(Request $request)
    {
        /** @var UploadedFile $file */
        $file = $request->file('trello_json');
        Project::trello(new TrelloProject(JsonUtil::objectFrom($file)));
        return redirect()->route('projects.index');
    }
}
