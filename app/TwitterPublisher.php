<?php

namespace App;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use App\Post;
use App\User;
use App\Account;

class TwitterPublisher implements Publisher
{

    public function getScheduledPosts()
    {
        $posts = Post::with('account')->where('published', false)
            ->where('post_time', '<', date('Y-m-d H:i:s'))
            ->whereHas('account', function($query){
                $query->where('provider', 'twitter');
            })->get();

        return $posts;
    }

    public function publish($post)
    {
        try {
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

                if(file_exists(public_path('/storage/posts/'.$post->images->first()->image))){
                    $path = public_path('/storage/posts/' . $post->images->first()->image);
                } else {
                    $path = public_path('/storage/users/default.png');
                }

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
        } catch(RequestException $e) {
            // When Graph returns an error
            Account::where('id', $post->account_id)->update(['error' => 1]);
            echo 'Twitter returned an error: ' . $e->getMessage();
        }
    }
}
