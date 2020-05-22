@php
    use App\Mail;
    use Illuminate\Database\Eloquent\Collection;
    /** @var Collection $mails */
    /** @var Mail $mail */
@endphp

@extends('layouts.app', ['active_page' => 'inbox', 'page_title' => 'Inbox'])

@push('style')
    <link rel="stylesheet" href="{{ asset('css/mailing.css') }}"/>
@endpush

@section('content')
    <div class="container-fluid h-100 d-flex flex-column">
        <div class="row flex-shrink-0">
            <div class="col-12 mb-1">
                <div class="btn-toolbar" role="toolbar">
                    <div class="btn-group mr-md-2" role="group" aria-label="Third group">
                        <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="bottom"
                                title="New mail" onclick="NewMail();"><i class="far fa-plus-square"></i></button>
                    </div>
                    <div class="btn-group mr-md-2" role="group" aria-label="First group">
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                title="Inbox" onclick="Inbox();"><i class="fas fa-inbox"></i></button>
                        <button type="button" class="btn btn-primary" data-toggle="tooltip" data-placement="bottom"
                                title="Sent" onclick="Sent();"><i class="far fa-paper-plane"></i></button>
                    </div>
                    <div class="btn-group mr-md-2" role="group" aria-label="Second group">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                                title="Reply" onclick="Reply();"><i class="fas fa-reply"></i></button>
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                                title="Forward" onclick="Forward();"><i class="fas fa-share"></i></button>
                    </div>
                    <div class="btn-group" role="group" aria-label="Third group">
                        <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="bottom"
                                title="Delete" onclick="Print();"><i class="fas fa-print"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <input id="selected_mail" type="hidden" value=""/>
        <input id="user_name" type="hidden" value="{{ Auth::user()->username }}"/>
        <input id="folder" type="hidden" value="inbox"/>
        <div class="row flex-fill" style="min-height:0">
            <div class="col-4 border scrollable">
                <div id="ajax_list">

                </div>
            </div>
            <div class="col border scrollable">
                <div id="ajax_mail">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/mailing_ajax.js') }}"></script>
    <script src="{{ asset('js/mailing.js') }}"></script>
    <script>$('button').tooltip({boundary: 'window'}); </script>
@endpush
