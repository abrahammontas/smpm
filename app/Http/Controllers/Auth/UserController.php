<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /*
     * Ensure the user is signed in to access this page
     */
    public function __construct() {

        $this->middleware('auth');

    }

    public function index() {
        $user = Auth::user();

        return view('user.edit', ['user' => $user]);
    }

    public function change(Request $request) {
        if(Auth::user()->password)
            return view('auth.passwords.change');

        $request->session()->flash('failure', 'Sorry! This account iscreated with social media. You can not change the password.');
        return redirect('/home');
    }

    /**
     * Update the password for the user.
     *
     * @param  Request  $request
     * @return Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::find(Auth::id());
        $hashedPassword = $user->password;

        if (Hash::check($request->old, $hashedPassword)) {
            //Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            $request->session()->flash('success', 'Your password has been changed.');

            return back();
        }

        $request->session()->flash('failure', 'Your password has not been changed.');

        return back();
    }

    public function edit(Request $request) {

        $this->validate($request, [
            'name' => 'required'
        ]);

        $user = Auth::user();

        if($request->image) {
            $hash = md5(microtime());
            Storage::disk('local')->put('/posts/'.$hash.'.'.$request->image->extension(), file_get_contents($request->file('image')));

            $user->fill([
                'image' => $hash.'.'.$request->image->extension()
            ])->save();
        }

        $user->fill([
            'name' => $request->name
        ])->save();

        $request->session()->flash('success', 'Your perfile has been updated.');

        return back();
    }
}