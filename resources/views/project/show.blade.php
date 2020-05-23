@php
    use App\Project;
    /** @var Project $project */
@endphp


@extends('layouts.app', ['active_page' => 'project', 'page_title' => 'My Projects'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/project.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('project.partial.descriptor', ['project' => $project])
            @include('project.partial.summary'   , ['project' => $project])
        </div>
    </div>
@endsection

@if($project->owner()->id == Auth::user()->id)
    @push('scripts')
        <script src="{{ asset('js/project_editing.js') }}"></script>
    @endpush
@endif
