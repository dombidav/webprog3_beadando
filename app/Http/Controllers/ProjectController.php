<?php

namespace App\Http\Controllers;

use App\Project;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
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
        return view('project.index', ['projects' => Auth::user()->projects()->paginate(5)]);
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
        $project = Project::create([
            'name' => $request->get('input_name')
        ]);
        $project->save();
        return redirect()->route('project.index');
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

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Project $project
     * @return \Illuminate\Http\RedirectResponse|Response
     */
    public function update(Request $request, Project $project)
    {
        if($request->get('new_name'))
            $project->name = $request->get('new_name');
        if($request->get('new_description') !== null)
            $project->description = $request->get('new_description');
        if($request->get('new_user_id') !== null)
            $project->user_id = $request->get('new_user_id');
        if($request->get('new_is_private') !== null)
            $project->is_private = $request->get('new_is_private');
        if($request->get('new_completed') !== null)
            $project->completed = $request->get('new_completed');
        if($request->get('new_deadline') !== null)
            $project->deadline = $request->get('new_deadline');
        $project->save();
        return redirect()->route('projects.show', $project->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Project $project
     * @return \Illuminate\Http\RedirectResponse|Response
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('project.index');
    }
}
