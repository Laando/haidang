<?php namespace App\Http\Requests\Auth;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Session;

class LoginRequest extends Request {

    public function authorize()
    {
        return true;
    }
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
        Session::flash('loginOn', 'Ok');
		return [
			'log' => 'required', 'password' => 'required',
		];
	}
    public function messages()
    {
        return [
            'log.required' => 'Vui lòng nhập Username/Email/Phone',
            'password.required' => 'Password không được để trống',
        ];
    }

}
