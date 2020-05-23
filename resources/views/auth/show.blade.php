@extends('layouts.app', ['active_page' => 'profile', 'page_title' => 'Show profile'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}"/>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Profile</div>
                    <div class="card-body">
                        <div class="container emp-profile">
                            <form method="post">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="profile-img">
                                            <img src="{{ asset('images/users/' . ($user->image ?? 'unknown.jpg')) }}"
                                                 alt=""/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="profile-head">
                                            <h5>
                                                {{ $user->full_name }}
                                            </h5>
                                            <h6>
                                                <br>
                                            </h6>
                                            <p class="proile-rating"><br></p>
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="home-tab" data-toggle="tab"
                                                       href="#home" role="tab" aria-controls="home"
                                                       aria-selected="true">About</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="profile-tab" data-toggle="tab"
                                                       href="#profile" role="tab" aria-controls="profile"
                                                       aria-selected="false">Timeline</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('user.edit') }}" class="profile-edit-btn">Edit Profile</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content profile-tab" id="myTabContent">
                                            <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                 aria-labelledby="home-tab">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>User Id</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>{{ $user->username }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Name</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>{{ $user->full_name }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Email</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p> {{ $user->email }} </p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label>Git</label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <p>{{ $user->git ?? "N/A" }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="profile" role="tabpanel"
                                                 aria-labelledby="profile-tab">
                                                @if($user->projects->count() < 1)
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <label>No projects to show</label>
                                                        </div>
                                                    </div>
                                                @else
                                                    @foreach($user->projects->take(2) as $project)
                                                        <div class="mb-md-5 row border-info">
                                                            <div class="col-md-12 truncate">
                                                                <h3>{{ $project->name }}</h3>
                                                                {!! $project->description !!}
                                                            </div>
                                                            <div class="col-md-12 mt-md-3">
                                                                <a href="{{ route('project.show', $project->id) }}" class="btn btn-block btn-outline-primary">See this project >></a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/tooltip.js') }}"></script>
@endpush
