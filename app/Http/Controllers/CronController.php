<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CronController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fb = new \Facebook\Facebook();

        try {
            $user = Auth::user();

            // Get the \Facebook\GraphNodes\GraphUser object for the current user.
            // If you provided a 'default_access_token', the '{access-token}' is optional.
            $response = $fb->get('/me/accounts', $user->socialProviders()->where('provider', '=', 'facebook')->first()->token);
            $token = $response->getAccessToken();

            $data = [
                'message' => 'My awesome photo upload example.',
                'source' => $fb->fileToUpload('https://media.licdn.com/media/AAEAAQAAAAAAAANbAAAAJDE5NjBkNDk1LTY3ZGQtNDA0NS04YTJiLTdkNmU3NjZiNjI3Mg.png'),
            ];

            $img = $fb->post('/me/photos', $data, $token);

        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        $graphNode = $img->getGraphNode();

        echo 'Photo ID: ' . $graphNode['id'];
    }
}
