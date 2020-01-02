<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class SubmitCartRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
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
        $user = Auth::user();
        if($user==null) {
            return [
                'username' => 'max:255|unique:users',
                'email' => 'email|max:255|unique:users',
                'password' => 'required|confirmed|min:8',
                'fullname' => 'max:255',
                'phone' => 'required|min:8|max:13|unique:users',
                'address' => 'required|max:255',
                'gender' => array('Regex:/^(1)|(2)|(3)$/'),
            ];
        } else {
            if($user->phone == '') {
                return [
                    'phone' => 'required|min:8|max:13|unique:users',
                    'address' => 'required|max:255',
                ];
            } else {
                return [
                    'phone' => 'required|min:8|max:13|exists:users,phone,id,' . $user->id,
                    'address' => 'required|max:255',
                ];
            }
        }
	}
    public function messages()
    {
        return [
            'phone.exists'=>'Số điện thoại phải là số đăng ký',
            'username.max' => 'Username tối đa :attribute ký tự',
            'username.unique' => 'Username đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email tối đa :attribute ký tự',
            'email.unique' => 'Email đã được đăng ký',
            'fullname.max' => 'Họ tên tối đa :attribute ký tự',
            'phone.required' => 'Điện thoại không được để trống (Vùi lòng điền thông tin chính xác cho việc xác nhận vé tour)',
            'phone.min' => 'Điện thoại không đúng định dạng',
            'phone.max' => 'Điện thoại không đúng định dạng',
            'phone.unique' => 'Điện thoại đã được đăng ký',
            'address.max' =>'Địa chỉ tối đa :attribute ký tự',
            'password.required'=> 'Vui lòng nhập password',
            'password.confirmed'=>'Xác nhận password không đúng',
            'address.required' =>'Địa chỉ phải có (Vùi lòng điền thông tin chính xác cho việc giao/nhận vé tour)',
            'gender.regex' => 'Giới tính không đúng định dạng'
        ];
    }
    public function response(array $errors)
    {
        session()->flash('submitCart','Có lỗi');
        if ($this->ajax() || $this->wantsJson())
        {
            return new JsonResponse($errors, 422);
        }
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }
}
