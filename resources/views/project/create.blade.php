@extends('layouts.app', ['active_page' => 'project', 'page_title' => 'New Projects'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/amsify.suggestags.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid">
        <form method="post" action="{{ route('projects.store') }}">
            @csrf
            <div class="row mt-2">
                <div class="col-md-6">
                    <label for="new_name">Project Name: </label>
                    <input id="new_name" name="new_name" type="text" class="@error('new_name') is-invalid @enderror form-control" required>
                    @error('new_name')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="new_deadline">Deadline: </label>
                    <input id="new_deadline" name="new_deadline" type="datetime-local" class="@error('new_deadline') is-invalid @enderror form-control">
                    @error('new_deadline')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <label for="new_responsibles">Members: </label>
                    <input id="new_responsibles" name="new_responsibles" type="text" class="@error('new_responsibles') is-invalid @enderror form-control">
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
