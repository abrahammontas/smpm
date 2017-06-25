<?php

namespace App;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Account;

class FacebookPublisher implements Publisher
{
    public function getScheduledPosts()
    {
        $posts = Post::with('account')->where('published', false)
            ->where('post_time', '<', date('Y-m-d H:i:s'))
            ->whereHas('account', function($query){
                $query->where('provider', 'facebook');
            })->get();

        return $posts;
    }

    public function publish($post)
    {
        $fb = new \Facebook\Facebook();

        try {
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

            if(file_exists(url('/storage/posts/'.$post->images->first()->image))){
                $path = url('/storage/posts/' . $post->images->first()->image);
            } else {
                $path = url('/storage/users/default.png');
            }

            if(count($post->images) > 0) {
                $data = [
                    'message' => $post->text,
                    'source' => $fb->fileToUpload($path),
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
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
        }

    }
}
