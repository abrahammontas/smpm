<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Socialite;
use Session;
use App\Http\Controllers\Controller;
use App\Account;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role_id' => 2,
        ]);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        if($provider == 'facebook') {
            return Socialite::driver($provider)->scopes(['publish_actions', 'manage_pages', 'publish_pages'])->redirect();
        } else {
            return Socialite::driver($provider)->redirect();
        }
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        session('message','');
        session('class-message','alert alert-success');

        try
        {
            $socialUser = Socialite::driver($provider)->user();
        }

        catch(\Exception $e)
        {
            session('message',$e);
            session('class-message','alert alert-danger');
            return redirect('/');
        }

        if(isset($socialUser->tokenSecret)) {
            $tSecret = $socialUser->tokenSecret;
        } else {
            $tSecret = "";
        }

        if(Auth::check()) {
            $user= Auth::user();
            $account = Account::where('provider_id',$socialUser->getId())
                ->where('user_id', '=', $user->id)
                ->first();

            if($account) {
                $account->update([
                    'token' => $socialUser->token, 
                    'token_secret' => $tSecret
                    ]);
            } else {
                $account = $user->accounts()->create(
                    [
                        'provider_id' => $socialUser->getId(),
                        'provider' => $provider,
                        'token' => $socialUser->token, 
                        'token_secret' => $tSecret,
                        'alias' => $socialUser->getName()."'s ".$provider,
                        'facebook_page' => 0
                    ]
                );
            }

        } else {
            $user = User::where('email', '=', $socialUser->getEmail())->first();

            if(!$user) {
                $user = User::create(
                    ['email' => $socialUser->getEmail(),
                    'name' => $socialUser->getName(),
                    'role_id' => 2]
                );

                $account = $user->accounts()->create(
                            [
                                'provider_id' => $socialUser->getId(),
                                'provider' => $provider,
                                'token' => $socialUser->token, 
                                'token_secret' => $tSecret,
                                'alias' => $socialUser->getName()."'s ".$provider,
                                'facebook_page' => 0
                            ]
                        );
            } else {

                $account = Account::where('provider_id',$socialUser->getId())
                    ->where('user_id', '=', $user->id)
                    ->first();

                if(!$account) {
                    $account = $user->accounts()->create(
                                [
                                    'provider_id' => $socialUser->getId(),
                                    'provider' => $provider,
                                    'token' => $socialUser->token, 
                                    'token_secret' => $tSecret,
                                    'alias' => $socialUser->getName()."'s ".$provider,
                                    'facebook_page' => 0
                                ]
                            );

                } else {
                    $account->update([
                            'token' => $socialUser->token, 
                            'token_secret' => $tSecret,
                            'facebook_page' => 0
                            ]);
                }
            }
        }

        if($provider == 'facebook') {
            $fb = new \Facebook\Facebook();

            $data = [
               'grant_type' => 'fb_exchange_token',
               'client_id' => env('FB_ID'),
               'client_secret' => env('FB_SECRET'),
               'fb_exchange_token' => $socialUser->token
            ];

            $url = '/oauth/access_token' ;

            $response = $fb->post($url, $data, $socialUser->token);

            $account->update([
                        'token' => $response->getAccessToken()
                        ]);
        }

        $account->update([
        'father_id' => $account->id
        ]);

        if(Auth::check()) {
            session('message', 'The account called "'.$socialUser->getName()."'s ".$provider." has been created succesfully!");
            return redirect('/account');
        }
        else {
            auth()->login($user);
            return redirect('/home');
        }
    }

}
