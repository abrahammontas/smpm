<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;

class CronController extends Controller
{
    /**
     * Publish post for all the providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->facebook();
    }


    public function facebook()
    {
        $fb = new \Facebook\Facebook();

       try {

            $posts = Post::with('account')->where('published', false)
                        ->where('post_time', '<', date('Y-m-d H:i:s'))
                        ->whereHas('account', function($query){
                            $query->where('provider', 'facebook');
                        })->get();

           foreach($posts as $post) {
               $user = User::where('id', '=', $post->account->user->id)->first();

               // Get the \Facebook\GraphNodes\GraphUser object for the current user.
               // If you provided a 'default_access_token', the '{access-token}' is optional.
               $response = $fb->get('/me/accounts', $post->account->token);
               $accessToken = $response->getAccessToken();

                if(count($post->images) > 0) {
                   $data = [
                       'message' => 'My awesome photo upload example.',
                       'source' => $fb->fileToUpload('https://media.licdn.com/media/AAEAAQAAAAAAAANbAAAAJDE5NjBkNDk1LTY3ZGQtNDA0NS04YTJiLTdkNmU3NjZiNjI3Mg.png'),
                   ];
                   $url = '/me/photos';

                } else {
                    $data = [
                       'message' => 'My awesome photo upload example.',
                    ];
                    $url = $post->account->provider_id.'/feed';
                } 

               $img = $fb->post($url, $data, $accessToken);

               Post::where('id', $post->id)->update(['published' => 1]);
           }

       } catch(\Facebook\Exceptions\FacebookResponseException $e) {
           // When Graph returns an error
           echo 'Graph returned an error: ' . $e->getMessage();
           exit;
       } catch(\Facebook\Exceptions\FacebookSDKException $e) {
           // When validation fails or other local issues
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
           exit;
       }

       print_r($user);
    }

    public function twitter() 
    {
       try {

            $posts = Post::with('account')->where('published', false)
                        ->where('post_time', '<', date('Y-m-d H:i:s'))
                        ->whereHas('account', function($query){
                            $query->where('provider', 'facebook');
                        })->get();

           foreach($posts as $post) {
                $user = User::where('id', '=', $post->account->user->id)->first();
                $stack = \GuzzleHttp\HandlerStack::create();

                $middleware = new \GuzzleHttp\Subscriber\Oauth\Oauth1([
                    'consumer_key'    => env('TWITTER_ID'),
                    'consumer_secret' => env('TWITTER_SECRET'),
                    'token' => $post->account->token,
                    'token_secret' => $post->account->token_secret,
                ]);

                $stack->push($middleware);

                $client = new \GuzzleHttp\Client([
                    'base_uri' => 'https://api.twitter.com/1.1/',
                    'handler' => $stack,
                    'auth' => 'oauth'
                ]);

                $response = $client->post('statuses/update.json', [
                    'form_params' => [
                        'status' => 'Test Tweet'
                    ]
                ]);
            }
        } catch(\GuzzleHttp\Subscriber\Exceptions $e) {
                   // When Graph returns an error
                   echo 'Graph returned an error: ' . $e->getMessage();
               }

    }
}
