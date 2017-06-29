<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Post;
use Auth;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $accounts = Account::where('user_id', $user->id)->get();

        $dashboard = [];

        foreach($accounts as $account) {
            $dashboard[] = array (
                'account' => $account,
                'total' => count(Post::where('account_id', $account->id)->get()),
                'published' => count(Post::where('account_id', $account->id)->where('published', 1)->get())
            );
        }

        return view('home', ['dashboard' => $dashboard]);
    }
}
