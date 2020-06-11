<?php

namespace App\Http\Controllers\Service;

use Illuminate\Http\Request;
use \App\Repositories\FriendRepository as FriendRepository;
use Zalo\Zalo;
use Zalo\ZaloEndPoint;


class FriendService extends \App\Http\Controllers\Controller
{
    protected $zalo;
    protected $config;
    protected $helper;
    protected $friendRepository;

    public function __construct(FriendRepository $friendRepository) {
        $this->friendRepository = $friendRepository;
        $this->config = [
            'app_id' => config('zalo.app_id'),
            'app_secret' => config('zalo.app_secret'),
            'callback_url' => config('zalo.callback_url'),
            'endpoint' => config('zalo.endpoint')
        ];
        $this->zalo = new Zalo($this->config);
        $this->helper = $this->zalo->getRedirectLoginHelper();

    }

    public function find(Request $request) {
        $filter = $this->buildFilter($request);
        $result = $this->friendRepository->find($filter);
        $pageSize = $filter['pageSize'];
        $pageId = $filter['pageId'];
        unset($filter['pageSize']);
        unset($filter['pageId']);
        $filter['metric'] = 'count';
        $totalRecord = $this->friendRepository->find($filter);
        $pagesCount = $this->recordsCountToPagesCount($totalRecord, $pageSize);
        $resposne = [
            'status' => 'successful',
            'result' => $result,
            'pageId' => $pageId,
            'pagesCount' => $pagesCount
        ];
        return response()->json($resposne);
    }

    private function buildFilter($request) {
       $columns = ['account_id', 'full_name', 'gender'];
       $filter = $this->friendRepository->buildFilter($request, $columns);
       $filter['orders'] = ['full_name' => 'ASC'];
       return $filter;
    }


    public function fetchFriends(Request $request) {
        $account = [
            'id' => 1, 
            'name' => 'Tung', 
            'image' => 'https://s120-ava-talk.zadn.vn/1/6/d/b/2/120/e6e60b7c70f0b5ca34c5e07c93af09d8.jpg', 
            'auth_code' => '0oTiQksKkaGcRsLZex6yP6HB6HJXhyqT84rf4zRnfm4ES6KKyuUwDtGkS1cEwDrY0WiFQyBIldKJKqnepTs2TZ8oH6ArwRHAUneiACJ3_o0P85qAzgUq72aZEX7eyPvh8t4Y88sjWqm1M4e-a--oL34m1XZafhbRNWmyRi_rysbFLKTpqx6M4n5GM2FkmDvtS1fD3Tktxt4USGfbvgojE6nPP4pNsRW4BKaJIQYQnIC3DaTPc__K5YPZBJ6rZlyWIMf04Axgj1fsRM9asSJg0m6D3oJFNk1dGuyXNF1Ji506v7HS6u3SKTDFDUJAFWx31SsQeEXOBBnUgE-Tt4PndsVQpfhcF7VU5uA4lFmZDQfUMIRI53zTqPohJW'
        ];
        session(['account' => $account]);
        $accessToken = $this->getAccessToken();
        $resposne = [
            'status' => 'fail'
        ];
        if ($accessToken != '') {
            $url = $this->config['endpoint'] . '/invitable_friends?access_token=' . $accessToken . '&from=0&limit=100&fields=id,name,gender,picture';
            $output = $this->triggerSyncRequest($url);
            if ($output) {
                $this->saveFriends($output);
                if (isset($output['paging']['next'])) {
                    $this->getFriends($output['paging']['next']);
                }
                $resposne['status'] = 'successful';
                $resposne['message'] = 'Fetch friend successfully';
            }
        }
        return response()->json($resposne);
    }

    private function getFriends($url) {
        $output = $this->triggerSyncRequest($url);
        if ($output) {
            $this->saveFriends($output);
            if (isset($output['paging']['next'])) {
                $this->getFriends($output['paging']['next']);
            }
        } else {
            return;
        }
    }

    private function saveFriends($output) {
        if ($output['data'] && is_array($output['data'])) {
            foreach($output['data'] as $item) {
                $saveData = [
                    'api_id' => $item['id'],
                    'full_name' => $item['name'],
                    'gender' => 0
                ];
                if ($item['gender'] == 'male') {
                    $saveData['gender'] = 1;
                }
                if (isset($item['picture']['data']['url'])) {
                    $saveData['avatar'] = $item['picture']['data']['url'];
                }
                $checkExists = $this->friendRepository->checkExists(['api_id' => $item['id']]);
                if ($checkExists) {
                    $this->friendRepository->updateByField(['api_id' => $item['id']], $saveData);
                } else {
                    $this->friendRepository->create($saveData);
                }
            }
        }
    }

    private function getAccessToken() {
        $account = session('account');
        $url = 'https://oauth.zaloapp.com/v3/access_token?app_id=' . $this->config['app_id'] . '&app_secret=' . $this->config['app_secret'] . '&code=' . $account['auth_code'];
        $output = $this->triggerSyncRequest($url);
        $retVal = '';
        if ($output && isset($output['access_token'])) {
            $retVal = $output['access_token'];
        } 
        return $retVal;
    }

    public function sendMessage(Request $request) {
        $account = [
            'id' => 1, 
            'name' => 'Tung', 
            'image' => 'https://s120-ava-talk.zadn.vn/1/6/d/b/2/120/e6e60b7c70f0b5ca34c5e07c93af09d8.jpg', 
            'auth_code' => '0oTiQksKkaGcRsLZex6yP6HB6HJXhyqT84rf4zRnfm4ES6KKyuUwDtGkS1cEwDrY0WiFQyBIldKJKqnepTs2TZ8oH6ArwRHAUneiACJ3_o0P85qAzgUq72aZEX7eyPvh8t4Y88sjWqm1M4e-a--oL34m1XZafhbRNWmyRi_rysbFLKTpqx6M4n5GM2FkmDvtS1fD3Tktxt4USGfbvgojE6nPP4pNsRW4BKaJIQYQnIC3DaTPc__K5YPZBJ6rZlyWIMf04Axgj1fsRM9asSJg0m6D3oJFNk1dGuyXNF1Ji506v7HS6u3SKTDFDUJAFWx31SsQeEXOBBnUgE-Tt4PndsVQpfhcF7VU5uA4lFmZDQfUMIRI53zTqPohJW'
        ];
        $userId = $request->input('user_id', null);
        $message = $request->input('message', '');
        if ($userId != null && $message != '') {
            $data = [
                'recipient' => [
                    'user_id' => $userId
                ],
                'message' => [
                    'text' => $message
                ]
            ];
            $header = ['Content-Type: application/json'];
            $accessToken = '-b8X9CpNu5RwMISiojdiN_fVB2xJdkqWx4TB1DgexWpiILTvg9oJSfyIMNJNu_bQdGPDSksStKMxNcatv9FrAfHqJX3xil0wbqvG5khDrIUaB7OCrkkmFBSn94VSxBbsiHe7Rlt8Xa_AHW51XOYbLUPt06ROi81bdc4YQzERcmIMO0urt8sr5P9qBsJ5gRn2hsS5DjYneZ-QJXi9rQw278fZEM_RXOziibStGOMbdqlGO1W-XEIiBznWBXxZlQfirISGLBxPeq_M0nXVfkwQ9DCl2G5ECrS7j_92pilhLW';
            $url = 'https://openapi.zalo.me/v2.0/oa/message?access_token=' . $accessToken;
            $output = $this->triggerSyncRequest($url, 'POST', $data, $header);
            echo '<pre>';
            print_r($output);
            echo '</pre>';
            exit();
        }
    }

    public function test(Request $request)
    {
        $input = $request->all();
        \Log::info(json_encode($input));
    }
}
