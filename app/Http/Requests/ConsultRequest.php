<?php namespace App\Http\Requests;
use Illuminate\Support\Facades\Auth;
class ConsultRequest extends Request {

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
    public function authorize()
    {
        return true;
    }
	public function rules()
	{

		return [
            'phone' =>'required|min:8|max:13',
            'tour_id' => 'numeric'
		];
	}
    public function messages()
    {
        return [

            'phone.min' => 'Điện thoại không đúng định dạng min',
            'phone.max' => 'Điện thoại không đúng định dạng max',
            'phone.regex' => 'Điện thoại không đúng định dạng '
        ];
    }

}