<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

class FriendController extends \App\Http\Controllers\Controller
{
    public function index(Request $request) {
        return view('friend.index');
    }
}
