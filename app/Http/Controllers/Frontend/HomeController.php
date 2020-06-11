<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;
use \App\Repositories\AccountRepository as AccountRepository;

class HomeController extends \App\Http\Controllers\Controller
{
    protected $zalo;
    protected $config;
    protected $helper;
    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository) {
        $this->config = [
            'app_id' => config('zalo.app_id'),
            'app_secret' => config('zalo.app_secret'),
            'callback_url' => config('zalo.callback_url'),
            'endpoint' => config('zalo.endpoint')
        ];
        $this->zalo = new Zalo($this->config);
        $this->helper = $this->zalo->getRedirectLoginHelper();
        $this->accountRepository = $accountRepository;
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
        if ($output) {
            $data = [
                'uid' => $output['id'],
                'full_name' => $output['name'],
                'auth_code' => $oauthCode
            ];
            if (isset($output['picture']['data']['url'])) {
                $data['image'] = $output['picture']['data']['url'];
            }
            $user = \Auth::user();
            if ($user) {
                $data['user_id'] = $user->id;
            }
            $checkExist = $this->accountRepository->checkExists(['uid' => $output['id']]);
            if ($checkExist) {
                $account = $this->accountRepository->updateByField(['uid' => $output['id']], $data);
            } else {
                $account = $this->accountRepository->create($data);
            }
            session(['account' => $account]);
            return redirect('http://soiket.site/friends');
        } else {
            return response('Not connected!', 401)->header('Content-Type', 'text/plain');;
        }
    }

    
}
