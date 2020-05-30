<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */

    protected function authenticated(Request $request, $user) {
        $redirectURL = '/';
        if(Session::has('redirection')) {
            $redirectURL = Session::get('redirection');
            Session::forget('redirection');
        }
        return redirect($redirectURL);
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    //overide function showLoginForm
    public function showLoginForm()
    {
        $parseUrl = parse_url(url()->previous(), PHP_URL_PATH);
        if(!empty($parseUrl) && !in_array($parseUrl, ['/'])) {
            Session::put('redirection', url()->previous());
        } else {
            Session::forget('redirection');
        }
        return view('auth.login');
    }

}
