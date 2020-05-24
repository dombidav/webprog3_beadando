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
                            <input type="text" id="trello_code" name="trello_code" class="form-control" placeholder="`https://trello.com/b/vXsYLRAJ` or just `vXsYLRAJ`">
                        </div>
                        <div class="col-md-2 text-center align-content-center align-items-center">
                            <h3>OR</h3>
                        </div>
                        <div class="col-md-5">
                            <input type="file" id="trello_json" name="trello_json" class="form-control file" placeholder="`https://trello.com/b/vXsYLRAJ` or just `vXsYLRAJ`">
                        </div>
                    </div>
                    <div class="row mt2">
                        <div class="col text-center">
                            <button type="submit" class="btn btn-primary">Create Project</button>
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
