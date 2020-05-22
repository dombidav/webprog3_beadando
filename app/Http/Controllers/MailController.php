<?php

namespace App\Http\Controllers;

use App\Mail;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Psy\Util\Str;

class MailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function indexInbox(Request $request)
    {
        /** @var User $user */
        $user = User::where('username', '=', $request->get('username'))->first();
        /** @var Collection $mails */
        $mails = $user->inbox;
        return view('mail.index', [
            'mails' => $mails->sortByDesc('is_new')->sortByDesc('priority')->sortByDesc('created_at'),
            'selected' => $request->get('selected'),
            'show_new' => true
        ]);
    }
    public function indexSent(Request $request)
    {
        /** @var User $user */
        $user = User::where('username', '=', $request->get('username'))->first();
        /** @var Collection $mails */
        $mails = $user->sent;
        return view('mail.index', [
            'mails' => $mails->sortByDesc('is_new')->sortByDesc('priority')->sortByDesc('created_at'),
            'selected' => $request->get('selected'),
            'show_new' => false
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        if(\request('action') != null){
            $mail = Mail::find(\request('mail'));
            if(\request('action') == 're'){
                return view('mail.create', ['recipient' => $mail->sender->username, 'subject' => 'Re:'.$mail->subject, 'content' => $mail->content]);
            }else{
                return view('mail.create', ['subject' => 'Fwd:'.$mail->subject, 'content' => $mail->content]);
            }
        }
        return view('mail.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Response|Redirector
     */
    public function store(Request $request)
    {
        foreach (explode(',', $request->get('recipient')) as $recipient){
            $mail = new Mail();
            $mail->sender_id = User::where('username', '=', $request->get('sender'))->get('id')[0]->id;
            $mail->recipient_id = User::where('username', '=', $recipient)->get('id')[0]->id;
            $mail->subject = $request->get('subject');
            $mail->content = $request->get('content');
            $mail->priority = 4;
            $mail->save();
        }
        return redirect(route('user.inbox'));
    }

    /**
     * Display the specified resource.
     *
     * @param Mail $mail
     * @return Factory|View
     */
    public function show(Mail $mail)
    {
        if(Auth::user() == $mail->recipient){
            $mail->is_new = false;
            $mail->save();
        }
        return view('mail.show', ['mail' => $mail]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Mail $mail
     * @return RedirectResponse|Response
     */
    public function destroy(Mail $mail)
    {
        try {
            $mail->delete();
        } catch (\Exception $e) {}
        return redirect()->route('user.inbox');
    }

    public function inbox(User $user){
        if($user->id == null)
            $user = Auth::user();
        return view('mail.mailing', ['user' => $user, 'mails' => $user->inbox->sortDesc()]);
    }
}
