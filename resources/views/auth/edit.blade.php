@extends('layouts.app', ['active_page' => 'profile', 'page_title' => 'Edit profile'])

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
                            <form action="{{ route('user.update') }}" method="POST">
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
                                                       aria-selected="true">Editing personal information</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <a href="{{ route('user.profile') }}" class="btn btn-outline-danger">Cancel</a>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                    </div>
                                    <div class="col-md-8">
                                        <div class="tab-content profile-tab" id="myTabContent">
                                                @csrf
                                                @method('put')
                                                <div class="tab-pane fade show active" id="home" role="tabpanel"
                                                     aria-labelledby="home-tab">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="username">User Id</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="text" class="form-control" name="username" id="username" readonly="readonly" value="{{ $user->username }}"></p>
                                                            @error('username')
                                                                <span class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="full_name">Name*</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="text" class="form-control" name="full_name" id="full_name" required="required" value="{{ $user->full_name }}"></p>
                                                            @error('full_name')
                                                            <span class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="email">Email*</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="text" class="form-control" name="email" id="email" required="required" value="{{ $user->email }}"></p>
                                                            @error('email')
                                                            <span  class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row border-bottom">
                                                        <div class="col-md-6">
                                                            <label for="git">Git</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="text" class="form-control" name="git" id="git" value="{{ $user->git ?? "" }}"></p>
                                                            @error('git')
                                                            <span class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <label for="new_password">New password</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="password" class="form-control" name="new_password" id="new_password" value="" placeholder="Keep current"></p>
                                                            @error('new_password')
                                                            <span class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mt-3">
                                                        <div class="col-md-6">
                                                            <label for="verify_password">Verify new password</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p><input type="password" class="form-control" name="verify_password" id="verify_password" value="" placeholder="Keep current"></p>
                                                            @error('verify_password')
                                                            <span class="alert-danger">{{ $message }}</span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <input type="submit" class="btn btn-primary"
                                                                   name="btnSaveChanges" value="Save changes"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
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
