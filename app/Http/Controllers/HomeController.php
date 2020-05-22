<?php

namespace App\Http\Controllers;

use Zalo\Zalo;

class HomeController extends Controller
{
    protected $zalo;
    protected $config;

    public function __construct() {
        $this->config = [
            'app_id' => config('zalo.app_id'),
            'app_secret' => config('zalo.app_secret'),
            'callback_url' => config('zalo.callback_url')
        ];
        $this->zalo = new Zalo($this->config);

    }

    public function getLogin(\Request $request) {
        $helper = $this->zalo -> getRedirectLoginHelper();
        $loginUrl = $helper->getLoginUrl($this->config['callback_url']);

        echo '<a href="' . $loginUrl . '">click here</a>';
    }

    public function callback(\Request $request) {
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!";
        $accessToken = $helper->getAccessToken($$this->config['callback_url']); // get access token
        echo '<pre>';
        print_r($accessToken);
        echo '</pre>';
        exit();
        if ($accessToken != null) {
            $expires = $accessToken->getExpiresAt(); // get expires time
        }
    }

}
