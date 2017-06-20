<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Account;
use App\Http\Requests;
use Session;
use Auth;
use App\Http\Requests\AccountRules;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $accounts = Account::where('user_id', '=', Auth::id())->get();

        return view('accounts.List', ['accounts' => $accounts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('accounts.Add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AccountRules $request)
    {
        $account = Account::create([
            'alias'    => $request->input('alias')
        ]);

        if(isset($account->id)){
            $message = "The account '".$request->input('alias')."' has been created successfully.";
            $class = "alert alert-success";
        }
        else{
            $message = "Error! please try again.";
            $class = "alert alert-danger";
        }

        return redirect('account')->with('message', $message)
            ->with('class', $class);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('accounts.Edit', ['account' => Account::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AccountRules $request, $id)
    {
        $account = Account::where('id', '=', $id)->update([
            'alias'    => $request->input('alias')
        ]);

        if(isset($account)){
            $message = "The account '".$request->input('alias')."' has been edited successfully.";
            $class   = "alert alert-success";
        }
        else{
            $message = "Error! please try again.";
            $class = "alert alert-danger";
        }

        return redirect('account')->with('message', $message)
            ->with('class', $class);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $account = Account::find($id);
        $account->delete();

        if(isset($account)){
            $message = "The account '".$account->name."' has been deleted successfully";
            $class = "alert alert-success";
        }
        else{
            $message = "Error! Please try again";
            $class = "alert alert-danger";
        }

        return redirect('account')->with('message', $message)
            ->with('class', $class);
    }

    public function pages($accountId) 
    {
        $fb = new \Facebook\Facebook();

       try {

           $account = Account::find($accountId);
           //$user = User::where('id', '=', $account->user->id)->first();

           // Get the \Facebook\GraphNodes\GraphUser object for the current user.
           // If you provided a 'default_access_token', the '{access-token}' is optional.
           $response = $fb->get('/me/accounts', $account->token);

           $fanPages = $response->getDecodedBody()['data'];

           if(count($fanPages) > 0) {
               return view('accounts.Pages', ['fanPages' => $fanPages, 'accountId' => $accountId]);
           }

           $message = "This account does not have any fan page linked.";
           $class = "alert alert-danger";

           return redirect('account')->with('message', $message)
               ->with('class', $class);

       }
       catch(\Facebook\Exceptions\FacebookResponseException $e) {
           // When Graph returns an error
           echo 'Graph returned an error: ' . $e->getMessage();
           exit;
       } catch(\Facebook\Exceptions\FacebookSDKException $e) {
           // When validation fails or other local issues
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
           exit;
       }
    }

    public function savePages(Request $request)
    {
        $fb = new \Facebook\Facebook();

        try {
                $accounts = $request->input('accounts');
                $father = $request->input('accountId');

                $user = Auth::user();

                $fbAccount = Account::where('user_id', $user->id)->where('provider', 'facebook')->where('facebook_page', 0)->first();

                // Get the \Facebook\GraphNodes\GraphUser object for the current user.
                // If you provided a 'default_access_token', the '{access-token}' is optional.
                $response = $fb->get('/me/accounts', $fbAccount->token);

                $fanPages = $response->getDecodedBody()['data'];

                foreach ($fanPages as $fanPage) {
                    if(in_array($fanPage['id'], $accounts)) {
                        $oldAccount = Account::where('provider_id',$fanPage['id'])->where('user_id', $user->id)->first();
                        if(!$oldAccount) {
                            Account::create([
                                'user_id' => $user->id,
                                'provider_id' => $fanPage['id'],
                                'provider' => 'facebook',
                                'token' => $fanPage['access_token'],
                                'token_secret' => "",
                                'alias' => $fanPage['name'] . "'s fan page",
                                'facebook_page' => true,
                                'father_id' => $father
                            ]);
                        } else {
                            Account::where('provider_id',$fanPage['id'])->update([
                                'token'    => $fanPage['access_token']
                            ]);
                        }
                    }
                }

                $message = "Fan pages added!";
                $class = "alert alert-success";

                return redirect('account')->with('message', $message)
                    ->with('class', $class);
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            $message = 'Graph returned an error: ' . $e->getMessage();
            $class = "alert alert-danger";
            echo $message;

            return redirect('account')->with('message', $message)
                ->with('class', $class);

        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            $message = 'Facebook SDK returned an error: ' . $e->getMessage();
            $class = "alert alert-danger";
            echo $message;
            return redirect('account')->with('message', $message)
                ->with('class', $class);
        }
    }
}
