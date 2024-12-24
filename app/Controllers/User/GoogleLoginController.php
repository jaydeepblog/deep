<?php

namespace App\Controllers\User;

require_once '../../vendor/autoload.php';

use App\Controllers\BaseController;
use App\Models\UserModel;
use Google_Client;
use Google_Service_Oauth2;

class GoogleLoginController extends BaseController
{

    private function setSession($google_id)
    {
        return $this->session->set([
            'google_id'   => $google_id,
            'logged_in'  => true,
        ]);
    }

    public function login()
    {
        $client = new Google_Client();
        $client->setClientId('1021572102196-2sqimjp9a0e80n56nim372u6n0h671lv.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri(base_url('/googleCallback'));
        $client->addScope('email');
        $client->addScope('profile');

        return redirect()->to($client->createAuthUrl());
    }

    public function googleCallback()
    {
        $client = new Google_Client();
        $client->setClientId('1021572102196-2sqimjp9a0e80n56nim372u6n0h671lv.apps.googleusercontent.com');
        $client->setClientSecret('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');
        $client->setRedirectUri(base_url('/googleCallback'));

        if($this->request->getGet('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($this->request->getGet('code'));
            $client->setAccessToken($token);

            $oauth2 = new Google_Service_Oauth2($client);
            $googleUser = $oauth2->userinfo->get();

            $model = new UserModel();
            $returnValue = $model->setUserGoogle($googleUser->email, $googleUser->id, $googleUser->picture);

            $this->setSession($googleUser->id);

            return redirect()->to('/board');
        }

        return redirect()->to('/login');
    }
}
