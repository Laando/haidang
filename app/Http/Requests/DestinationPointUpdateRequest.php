<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class DestinationPointUpdateRequest extends Request {

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
        return [
            'title' => 'required|max:255',
            'priority' =>array('Regex:/^(1)|(2)|(3)|(4)|(5)|(6)|(7)|(8)|(9)|(10)$/'),

        ];
	}

}
