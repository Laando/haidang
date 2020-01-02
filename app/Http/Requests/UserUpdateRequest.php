<?php namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class UserUpdateRequest extends Request {

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
		$id = $this->user;
		return $rules = [
			'username' => 'required|max:255|unique:users,username,' . $id,
			//'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|unique:users,phone,' . $id,
            'address' => 'max:255',
            'gender' =>array('Regex:/^(1)|(2)|(3)$/'),
            'dob' => 'required|max:255|date_format:d/m/Y',
		];
	}

}
