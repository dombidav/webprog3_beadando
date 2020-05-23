<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;
use mysql_xdevapi\Exception as ExceptionAlias;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function profile()
    {
        if (Auth::check())
            return view('auth.show', ['user' => Auth::user()]);
        else
            return view('auth.login');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        if (Auth::check())
            return view('auth.edit', ['user' => Auth::user()]);
        else
            return view('auth.login');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     * @throws ValidationException
     */
    public function update(Request $request, User $user)
    {
        /** @var \App\User $user */
        $user = \App\User::all()->where('username', '=', $request->get('username'))->first();
        if ($request->get('new_password') != null) {
            $request->validate([
                'username' => 'required|min:3|max:200',
                'full_name' => 'required|min:3|max:200',
                'email' => 'required|email|min:3|max:200',
                'new_password' => 'min:6|required_with:verify_password|same:verify_password|different:old_password',
                'password_confirmation' => 'min:6'
            ]);
        } else {
            $request->validate([
                'username' => 'required|min:3|max:200',
                'full_name' => 'required|min:3|max:200',
                'email' => 'required|email|min:3|max:200',
            ]);
        }
        if (DB::table('users')->where('id', '<>', $user->id)->where('email', '=', $request->get('email'))->count() > 0) {
            throw ValidationException::withMessages(['email' => 'Email is already taken']);
        }
        if (Auth::user()->id != $user->id) {
            abort(403, 'Unauthorized ' . Auth::user()->id . ' | ' . $user->id);
        }
        $user->email = $request->get('email');
        $user->full_name = $request->get('full_name');
        $user->git = $request->get('git');
        if ($request->get('new_password')) {
            $user->password = Hash::make($request->get('new_password'));
        }
        $user->save();
        return view('auth.show', ['user' => $user]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function search(string $name = ''){
        if($name == '' || strpos($name, '=') != -1){
            if(\request('term')){
                $name = \request('term');
            }
        }
        $query = User::query()->where('username', 'like', "$name%");
        if($query->count() == 0){
            $query = User::query()->where('username', 'like', "%$name%");
        }
        $suggestions['suggestions'] = [];
        $result = $query->orderBy('id')->limit(5)->get('username');
        foreach ($result as $user){
            try {
                array_push($suggestions['suggestions'], $user->username);
            }catch (Exception $e){}
        }
        return json_encode($suggestions['suggestions']); //json_encode($suggestions);
    }
}
