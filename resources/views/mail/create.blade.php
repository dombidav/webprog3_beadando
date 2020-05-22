@extends('layouts.app', ['active_page' => 'profile', 'page_title' => 'Edit profile'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/mailing.css') }}"/>
    <link rel="stylesheet" href="{{ asset('css/amsify.suggestags.css') }}"/>
@endpush

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">New message</div>
                    <div class="card-body">
                        <form action="{{ route('mails.store') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-md-1 align-items-center m-auto">
                                    <label for="sender">From: </label>
                                </div>
                                <div class="col">
                                    <p><input type="text" class="form-control" name="sender" id="sender" readonly="readonly" value="{{ Auth::user()->username }}"></p>
                                    @error('sender')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 align-items-center m-auto">
                                    <label for="recipient">To: </label>
                                </div>
                                <div class="col">
                                    <p><input type="text" class="form-control" name="recipient" required="required" id="recipient" value="{{ $recipient ?? '' }}"></p>
                                    @error('recipient')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-1 align-items-center m-auto">
                                    <label for="subject">Subject: </label>
                                </div>
                                <div class="col">
                                    <p><input type="text" class="form-control" name="subject" required="required" id="subject" value="{{ $subject ?? '' }}"></p>
                                    @error('subject')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 align-items-center m-auto">
                                    <label for="content">Message: </label>
                                </div>
                                <div class="col">
                                    <p><textarea class="form-control vh-50" name="content" required="required" id="content">
{!! isset($content) ? '&#13;&#10;&#13;&#10;ORIGINAL MESSAGE:&#13;&#10;&#13;&#10;---&#13;&#10;&#13;&#10;' : '' !!}
{{ $content ?? ''}}
                                        </textarea></p>
                                    @error('subject')
                                    <span class="alert-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                                <div class="float-right">
                                    <button type="submit" name="submit" class="btn btn-primary">Send</button>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
    <script>
        $('#recipient').amsifySuggestags({
            suggestions: [
                @foreach(\App\User::all() as $user)
                '{{ $user->username }}',
                @endforeach
            ]
        });
    </script>
@endpush
