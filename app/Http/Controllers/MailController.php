<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Psy\Util\Str;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexInbox(Request $request)
    {
        /** @var User $user */
        $user = User::where('username', '=', $request->get('username'))->first();
        /** @var Collection $mails */
        $mails = $user->inbox;
        return view('mail.index', [
            'mails' => $mails->sortByDesc('is_new')->sortByDesc('priority')->sortByDesc('created_at'),
            'selected' => $request->get('selected')
        ]);
    }
    public function indexSent(Request $request)
    {
        /** @var User $user */
        $user = User::where('username', '=', $request->get('username'))->first();
        return view('mail.index', ['mails' => $user->sent]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Mail $mail)
    {
        $mail->is_new = false;
        $mail->save();
        return view('mail.show', ['mail' => $mail]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function edit(Mail $mail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Mail $mail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mail  $mail
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mail $mail)
    {
        //
    }

    public function inbox(User $user){
        if($user->id == null)
            $user = Auth::user();
        return view('mail.mailing', ['user' => $user, 'mails' => $user->inbox->sortDesc()]);
    }
}
