<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;

class HomeController extends \App\Http\Controllers\Controller
{
    protected $zalo;
    protected $config;
    protected $helper;

    public function __construct() {
        $this->config = [
            'app_id' => config('zalo.app_id'),
            'app_secret' => config('zalo.app_secret'),
            'callback_url' => config('zalo.callback_url'),
            'endpoint' => config('zalo.endpoint')
        ];
        $this->zalo = new Zalo($this->config);
        $this->helper = $this->zalo->getRedirectLoginHelper();

    }

    public function connectZalo(\Request $request) {
        $uri = urlencode($this->config['callback_url']);
        $loginUrl = $this->helper->getLoginUrl($uri);
        echo '<a href="' . $loginUrl . '">click here</a>';
    }

    public function callback(Request $request) {
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!";
        $accessToken = $this->helper->getAccessToken($this->config['callback_url']);
        $url = $this->config['endpoint'] . '?access_token=' . $accessToken . '&fields=id,birthday,name,gender,picture';
        $output = $this->triggerSyncRequest($url);
        echo '<pre>';
        print_r($output);
        echo '</pre>';
        exit();
    }
}
