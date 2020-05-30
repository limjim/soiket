<?php

namespace App\Http\Controllers\System;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request) {
        return view('profile.index');
    }

    public function password(Request $request) {
        return view('profile.password');
    }
}
