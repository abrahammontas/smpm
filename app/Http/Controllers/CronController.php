<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Account;

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
        $this->twitter();
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
               $fatherAccount = Account::find($post->account->father_id);

               $response = $fb->get('/me/accounts', $fatherAccount->token);
               $pages = $response->getDecodedBody()['data'];

               foreach($pages as $page) {
                if($page['id'] == $post->account->provider_id) {
                  $pageAccessToken = $page['access_token'];
                  $post->account->update([
                            'token' => $pageAccessToken
                            ]);
                }
               }


               $accessToken = $response->getAccessToken();

                $data = [
                   'grant_type' => 'fb_exchange_token',
                   'client_id' => env('FB_ID'),
                   'client_secret' => env('FB_SECRET'),
                   'fb_exchange_token' => $accessToken
                ];

                $url = '/oauth/access_token' ;

                $response = $fb->post($url, $data, $response->getAccessToken());

                $fatherAccount->update([
                            'token' => $response->getAccessToken()
                            ]);


                if(count($post->images) > 0) {
                   $data = [
                       'message' => $post->text,
                       'source' => $fb->fileToUpload(url('/storage/posts/'.$post->images->first()->image)),
                   ];
                   if($post->account->facebook_page){
                      $url = '/'.$post->account->provider_id.'/photos';
                   } else {
                      $url = '/me/photos';
                   }
                } else {
                    $data = [
                       'message' => $post->text,
                    ];
                    $url = $post->account->provider_id.'/feed';
                }

              if($post->account->facebook_page){
                $fb->post($url, $data, $pageAccessToken);
              } else {
                $fb->post($url, $data, $accessToken);
              }

               Post::where('id', $post->id)->update(['published' => 1]);
           }

       } catch(\Facebook\Exceptions\FacebookResponseException $e) {
           // When Graph returns an error
           echo 'Graph returned an error: ' . $e->getMessage();
       } catch(\Facebook\Exceptions\FacebookSDKException $e) {
           // When validation fails or other local issues
           echo 'Facebook SDK returned an error: ' . $e->getMessage();
       }
    }

    public function twitter() 
    {
       try {

            $posts = Post::with('account')->where('published', false)
                        ->where('post_time', '<', date('Y-m-d H:i:s'))
                        ->whereHas('account', function($query){
                            $query->where('provider', 'twitter');
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

                if(count($post->images) > 0) {
                    $clientPost = new \GuzzleHttp\Client([
                        'base_uri' => 'https://upload.twitter.com/1.1/',
                        'handler' => $stack,
                        'auth' => 'oauth'
                    ]);

                    $path = url('/storage/posts/'.$post->images->first()->image);

                    $responseMedia = $clientPost->post('media/upload.json', [
                        'multipart' => [
                            [
                                'name'     => 'media',
                                'contents' => fopen($path, 'r')
                            ],
                        ]
                    ]);
                }

                $clientPost = new \GuzzleHttp\Client([
                    'base_uri' => 'https://api.twitter.com/1.1/',
                    'handler' => $stack,
                    'auth' => 'oauth'
                ]);

               if(count($post->images) > 0) {
                   $response = $clientPost->post('statuses/update.json', [
                       'form_params' => [
                           'status' => $post->text,
                           'media_ids' => json_decode($responseMedia->getBody())->media_id
                       ]
                   ]);
               } else {
                   $response = $clientPost->post('statuses/update.json', [
                       'form_params' => [
                           'status' => $post->text
                       ]
                   ]);
               }

               Post::where('id', $post->id)->update(['published' => 1]);
               Account::where('id', $post->account_id)->update(['error' => 0]);
            }
        } catch(RequestException $e) {
                   // When Graph returns an error
                   Account::where('id', $post->account_id)->update(['error' => 1]);
                   echo 'Twitter returned an error: ' . $e->getMessage();
               }

    }
}
