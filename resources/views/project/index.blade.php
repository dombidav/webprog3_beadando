@php
    use App\Mail;
    use App\Project;use Illuminate\Database\Eloquent\Collection;
    /** @var Collection<Project> $projects
    *   @var Project $project
    */
@endphp


@extends('layouts.app', ['active_page' => 'project', 'page_title' => 'My Projects'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}"/>
@endpush

@section('content')
    <div class="row">
        <div class="col-4 col-md-5"></div>
        <div class="col-4">{{ $projects->links() }}</div>
        <div class="col-4"></div>
    </div>
    <div class="container-fluid">
        <div class="row">

            <div class="col-12 col-md-6 col-lg-4 mb-4">
                <div class="card mx-auto text-center">
                    <div class="card-body">
                        <a href="{{ route('projects.create') }}" data-toggle="tooltip" data-placement="bottom" title="Create new Project"><i class="display-1 fas fa-plus-square"></i></a>
                    </div>
                </div>
            </div>

            @foreach($projects as $project)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card mx-auto ">
                        <div class="card-body card-fix">
                            <h5 class="card-title">{{ wordwrap($project->name) }}</h5>
                            <p class="card-text">Deadline: {{ $project->deadline ?? '--' }}</p>
                            <a href="{{ route('projects.show', $project->id) }}" class="btn btn-primary">Open</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $( document ).ready(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
@endpush
