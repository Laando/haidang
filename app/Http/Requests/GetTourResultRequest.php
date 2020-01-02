<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class GetTourResultRequest extends Request {

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
    public function messages()
    {
        return [
            'tour_adult.required'=>'Số người đăng ký không được để trống',
            'tour_adult.numeric'=>'Số người đăng ký phải là số'
        ];
    }
	public function rules()
	{
        return [
            'tour_adult' => 'required|numeric|between:1,100',
            'tour_child' => 'nullable|numeric|between:1,100',
            'tour_baby' => 'nullable|numeric|between:1,100',
            'tour_startdate' => 'date_format:d/m/Y|after:tomorrow',
            'tour_startdate_id' => 'required|numeric',
            'tour_standard' => 'nullable|numeric',
        ];
	}

}
