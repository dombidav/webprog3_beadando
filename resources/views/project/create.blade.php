@extends('layouts.app', ['active_page' => 'project', 'page_title' => 'New Projects'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/amsify.suggestags.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <a class="nav-item nav-link active" id="nav-manual-tab" data-toggle="tab" href="#nav-manual" role="tab"
                   aria-controls="nav-manual" aria-selected="true">Manual</a>
                <a class="nav-item nav-link" id="nav-trello-tab" data-toggle="tab" href="#nav-trello" role="tab"
                   aria-controls="nav-trello" aria-selected="false">Trello</a>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-manual" role="tabpanel" aria-labelledby="nav-manual-tab">
                <form method="post" action="{{ route('projects.store') }}">
                    @csrf
                    <input type="hidden" id="create_method" name="create_method" value="manual">
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label for="new_name">Project Name: </label>
                            <input id="new_name" name="new_name" type="text"
                                   class="@error('new_name') is-invalid @enderror form-control" required>
                            @error('new_name')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="new_deadline">Deadline: </label>
                            <input id="new_deadline" name="new_deadline" type="datetime-local"
                                   class="@error('new_deadline') is-invalid @enderror form-control">
                            @error('new_deadline')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="new_responsibles">Members: </label>
                            <input id="new_responsibles" name="new_responsibles" type="text"
                                   class="@error('new_responsibles') is-invalid @enderror form-control">
                            @error('new_responsibles')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col">
                            <label for="new_content">Description: </label>
                            <textarea id="new_content" name="new_content" class="form-control"></textarea>
                            @error('new_content')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-success">Create</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="nav-trello" role="tabpanel" aria-labelledby="nav-trello-tab">
                <form method="post" enctype="multipart/form-data" action="{{ route('projects.store') }}">
                    @csrf
                    <input type="hidden" id="create_method" name="create_method" value="trello">
                    <div class="row mt-2">
                        <div class="col-md-5">
                            <input type="file" id="trello_json" name="trello_json" class="form-control file"
                                   placeholder="`https://trello.com/b/vXsYLRAJ` or just `vXsYLRAJ`">
                        </div>
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary">Create Project</button>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col">
                            <div class="card">
                                <h5 class="card-header">Help</h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="card-text text-justify">You can quickly create projects from existing trello
                                                boards by exporting it (Show Menu > Print and Export > Export as JSON),
                                                however currently users are only added to the project and the tasks if
                                                their trello username is the same as their username here.</p>
                                            @if(config('app.debug') == true)
                                                <p class="mt-5 text-danger">DEBUG: developer mode is enabled in the <em>`.env`</em>
                                                    file. Every unknown username will be registered as new user with a
                                                    default password and WILL BE added to the project as members.</p>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <img src="{{ asset('images/trello-export-help.png') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
    <script>
        $('#new_responsibles').amsifySuggestags({
            suggestions: [
                @foreach(\App\User::all() as $user)
                    '{{ $user->username }}',
                @endforeach
            ]
        });
    </script>
@endpush
