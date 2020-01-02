<?php

namespace App\Http\Controllers\Auth;

use function GuzzleHttp\Promise\all;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

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
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        Session::put('backUrl', URL::previous());
        loadMenu();
    }
    /*protected function authenticated(Request $request, $user)
    {
        if ( $user->isAdmin() ) {// do your margic here
            return redirect()->route('dashboard');
        }
        return redirect('/home');
    }*/
    protected function redirectTo()
    {
        $user = auth()->user();
        $path = '/';
        $inputs = Request::capture()->all();
        if($inputs['backUrl']!==''){
            return $inputs['backUrl'];
        }
        if($user->isAdmin()){
            $path = '/admin';
        }
        if($user->isStaff()){
            $path = '/staff';
        }
        if($user->isAgent()){
            $path = '/agent';
        }
        if($path == '/') {
            return Session::get('backUrl') ? Session::get('backUrl') :   $this->redirectTo;
        } else {
            return $path ;
        }
    }
    protected function credentials(Request $request)
    {
        if(is_numeric($request->get('email'))){
            return ['phone'=>$request->get('email'),'password'=>$request->get('password')];
        }
        return $request->only($this->username(), 'password');
    }
}
