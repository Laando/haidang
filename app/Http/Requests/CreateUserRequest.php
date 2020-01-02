<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\JsonResponse;

class CreateUserRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
    public function authorize()
    {
        $user = Auth::user();
        return $user->role->slug == 'agent'||$user->role->slug == 'staff'||$user->role->slug == 'admin';
    }
    public function rules()
    {
            return [
                'username' => array('Regex:/^[a-zA-Z0-9]{0,20}$/'),
                'email' => 'email|max:255',
                'password' => 'required|confirmed|min:8',
                'fullname' => 'max:255',
                'phone' => array('Regex:/^\\d{8,13}$/'),
                'address' => 'required|max:255',
                'gender' => array('Regex:/^(1)|(2)|(3)$/'),
            ];
    }
    public function messages()
    {
        return [
            'username.alpha_num' => 'Username chỉ là ký tự alphabet hay số',
            'username.max' => 'Username tối đa :attribute ký tự',
            'username.unique' => 'Username đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'email.max' => 'Email tối đa :attribute ký tự',
            'email.unique' => 'Email đã được đăng ký',
            'fullname.max' => 'Họ tên tối đa :attribute ký tự',
            'phone.required' => 'Điện thoại không được để trống (Vùi lòng điền thông tin chính xác cho việc xác nhận vé tour)',
            'phone.numeric' => 'Điện thoại phải là số',
            'phone.min' => 'Điện thoại không đúng định dạng min',
            'phone.max' => 'Điện thoại không đúng định dạng max',
            'phone.regex' => 'Điện thoại không đúng định dạng regex',
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
        session()->flash('createUser','Có lỗi');
        if ($this->ajax() || $this->wantsJson())
        {
            //dd(json_encode($errors,JSON_UNESCAPED_UNICODE));
            return new JsonResponse($errors,422);
        }
        return $this->redirector->to($this->getRedirectUrl())
            ->withInput($this->except($this->dontFlash))
            ->withErrors($errors, $this->errorBag);
    }

}
