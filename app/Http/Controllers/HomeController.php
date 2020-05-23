<?php

namespace App\Http\Controllers;

use Zalo\Zalo;

class HomeController extends Controller
{
    protected $zalo;
    protected $config;
    protected $helper;

    public function __construct() {
        $this->config = [
            'app_id' => config('zalo.app_id'),
            'app_secret' => config('zalo.app_secret'),
            'callback_url' => config('zalo.callback_url')
        ];
        $this->zalo = new Zalo($this->config);
        $this->helper = $this->zalo->getRedirectLoginHelper();

    }

    public function getLogin(\Request $request) {
        $uri = urlencode($this->config['callback_url']);
        $loginUrl = $this->helper->getLoginUrl($uri);

        echo '<a href="' . $loginUrl . '">click here</a>';
    }

    public function callback(\Request $request) {
        $oauthCode = isset($_GET['code']) ? $_GET['code'] : "THIS NOT CALLBACK PAGE !!!";
        $accessToken = $this->helper->getAccessToken($this->config['callback_url']); // get access token
        $params = ['offset' => 0, 'limit' => 10, 'fields' => "id, name, birthday, picture"];
        $response = $zalo->get(ZaloEndpoint::API_GRAPH_FRIENDS, $accessToken, $params);
        $result = $response->getDecodedBody(); 
        echo '<pre>';
        print_r($result);
        echo '</pre>';
        exit();
    }

}
