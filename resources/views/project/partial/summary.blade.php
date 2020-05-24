@php
    /** @var \App\Project $project */
@endphp


<div class="col-12 col-md-6 col-lg-6 mb-4">
    <div class="card mx-auto ">
        <div class="card-body card-fix">
            <div class="card-header"><h5 class="card-title">Project Status</h5></div>
            <div class="row mt-2 border-bottom">
                <div class="col-md-4">
                    <label>Deadline</label>
                </div>

                <div class="col-md-4">
                    @php
                        $diff = date_diff(date_create($project->deadline), date_create('now'));
                        if($diff->d > 1)
                            $d_time = $diff->format('%a d');
                        else if($diff->d == 1)
                            $d_time = $diff->format('%a d %h h');
                        else if($diff->h > 9)
                            $d_time = $diff->format('%h h');
                        else if($diff->h > 0)
                            $d_time = $diff->format('%h h %i m');
                        else if($diff->i > 1)
                            $d_time = $diff->format('%i m');
                        else
                            $d_time = 'less than a minute';
                    @endphp
                    <p>{{ $d_time ?? '' }}</p>
                </div>
                <div class="col-md-4">
                    <p>{{ $project->deadline }}</p>
                </div>
            </div>
            <div class="row mt-2 border-bottom">
                <div class="col-md-4">
                    <label>Tasks</label>
                </div>
                <div class="col-md-4">
                    <a data-toggle="tooltip" title="See finished" class="text-success"
                       href="{{ route('tasks.index', [ 'p' => $project->id, 'filter'=>['status done']]) }}">{{ $project->tasks()->where('completed', '<>', null)->count() }}</a>
                    /
                    <a data-toggle="tooltip" title="See in progress" class="text-warning"
                       href="{{ route('tasks.index', [ 'p' => $project->id, 'filter'=>['status active']]) }}">{{ $project->tasks()->where('completed', '=', null)->where('status', '<>', 0)->count() }}</a>
                    /
                    <a data-toggle="tooltip" title="See backlog" class="text-danger"
                       href="{{ route('tasks.index', [ 'p' => $project->id, 'filter'=>['status backlog']]) }}">{{ $project->tasks()->where('completed', '=', null)->where('status', '=', 0)->count() }}</a>
                </div>
                <div class="col-md-4">
                    Assigned to me: <a
                        href="{{ route('tasks.index', [ 'p' => $project->id, 'filter'=>['target $', 'status active']]) }}">{{ \App\Task::tasksAssigned(Auth::user(), $project->id)->count() }}</a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-4">
                    <a class="btn btn-primary" href="{{ route('tasks.create', [ 'p' => $project->id]) }}">New Task</a>
                </div>
                <div class="col-md-4">
                </div>
                <div class="col-md-4">
                    <a class="btn btn-primary" href="{{ route('tasks.index', [ 'p' => $project->id]) }}">All Tasks</a>
                </div>
            </div>
        </div>
    </div>
</div>
