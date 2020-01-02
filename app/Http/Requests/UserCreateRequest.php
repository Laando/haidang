<?php namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class UserCreateRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
    public function authorize()
    {
        $user = Auth::user();
        return $user->role->slug == 'admin' || $user->role->slug == 'staff';
    }
	public function rules()
	{

		return [
            'username' => 'required|max:255|unique:users',
            'email' => 'email|max:255|unique:users',
            'password' => 'required|confirmed|min:8',
            'fullname' => 'max:255',
            'phone' =>'required|min:8|max:13|unique:users',
            'address' => 'max:255',
            'gender' =>array('Regex:/^(1)|(2)|(3)$/'),
            'dob' => 'required|max:255|date_format:d/m/Y',
		];
	}

}