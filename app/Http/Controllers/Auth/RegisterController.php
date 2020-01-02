<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        loadMenu();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if ($data['g-recaptcha-response']) {
            $captcha = $data['g-recaptcha-response'];
            $secretKey = '6Le_ftoSAAAAACsou0adDhkwNysZwCqFEEQyedyz';
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . $secretKey . "&response=" . $captcha);
            $responseKeys = json_decode($response, true);
            if (intval($responseKeys["success"]) !== 1) {
                return route('register')->withErrors(['google-captcha', 'Lỗi với Google Captcha : code 1']);
            } else {
                return Validator::make($data, [
                    'regfullname' => 'required|string|max:255',
                    'regphone' => 'required|numeric|digits_between:8,12|unique:users,phone',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:8|confirmed',
                ]);
            }
        }
        else {
            return route('register')->withErrors(['google-captcha', 'Lỗi với Google Captcha : code 0']);
        }

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->fullname = $data['regfullname'];
        $user->fullnameen =str_slug($data['regfullname']);
        $user->phone = $data['regphone'];
        $user->address = $data['regaddress'];
        $user->email = $data['email'];
        $user->password = bcrypt($data['password']);
        $user->role_id = 3 ;
        $user->save();
        return $user ;
    }
}
