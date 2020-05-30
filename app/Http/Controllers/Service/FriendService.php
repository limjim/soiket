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
            'callback_url' => config('zalo.callback_url')
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
        
    }

    private function getAccessToken() {
        
    }
}
